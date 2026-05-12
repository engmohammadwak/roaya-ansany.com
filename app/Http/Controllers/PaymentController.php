<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\PaymobSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private function settings(): PaymobSetting
    {
        return PaymobSetting::current();
    }

    // POST /{locale}/donate/payment/3d/form
    public function process(Request $request, string $locale)
    {
        $settings = $this->settings();

        // --- Test mode: skip gateway ---
        if ($settings->test_mode || !$settings->is_active) {
            $donation = Donation::create([
                'campaign_id'  => $request->input('campaign_id'),
                'donor_name'   => $request->input('name'),
                'donor_email'  => $request->input('email'),
                'amount'       => $request->input('amount'),
                'currency'     => $request->input('currency', 'USD'),
                'card_brand'   => $request->input('card_brand', 'unknown'),
                'description'  => $request->input('description'),
                'status'       => 'success',
                'gateway_ref'  => 'TEST-' . uniqid(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'       => true,
                    'test_mode'     => true,
                    'donation_id'   => $donation->id,
                    'campaign_name' => $this->getCampaignName($donation->campaign_id),
                    'amount'        => $donation->amount,
                    'currency'      => $donation->currency,
                ]);
            }
            return redirect()->route('donate', ['locale' => $locale])
                ->with('payment_success', true)
                ->with('donation_id', $donation->id);
        }

        // --- Real Paymob flow ---
        try {
            // Step 1: Auth token
            $authRes = Http::post($settings->base_url . '/api/auth/tokens', [
                'api_key' => $settings->api_key,
            ]);
            $token = $authRes->json('token');
            if (!$token) throw new \Exception('Auth failed');

            // Step 2: Register order
            $amountCents = (int) round((float) $request->input('amount') * 100);
            $orderRes = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->post($settings->base_url . '/api/ecommerce/orders', [
                    'auth_token'           => $token,
                    'delivery_needed'      => false,
                    'amount_cents'         => $amountCents,
                    'currency'             => $request->input('currency', 'USD'),
                    'items'                => [],
                ]);
            $orderId = $orderRes->json('id');
            if (!$orderId) throw new \Exception('Order registration failed');

            // Step 3: Payment key
            $pkRes = Http::withHeaders(['Authorization' => 'Bearer ' . $token])
                ->post($settings->base_url . '/api/acceptance/payment_keys', [
                    'auth_token'     => $token,
                    'amount_cents'   => $amountCents,
                    'expiration'     => 3600,
                    'order_id'       => $orderId,
                    'billing_data'   => [
                        'first_name'    => $request->input('name', 'N/A'),
                        'last_name'     => 'N/A',
                        'email'         => $request->input('email', 'na@na.com'),
                        'phone_number'  => 'N/A',
                        'street'        => 'N/A',
                        'city'          => 'N/A',
                        'country'       => 'N/A',
                        'state'         => 'N/A',
                        'postal_code'   => 'N/A',
                        'apartment'     => 'N/A',
                        'floor'         => 'N/A',
                        'building'      => 'N/A',
                        'shipping_method' => 'NA',
                    ],
                    'currency'            => $request->input('currency', 'USD'),
                    'integration_id'      => $settings->integration_id,
                    'lock_order_when_paid' => false,
                ]);
            $paymentKey = $pkRes->json('token');
            if (!$paymentKey) throw new \Exception('Payment key failed');

            // Step 4: Charge via iframe
            $chargeRes = Http::post(
                $settings->base_url . '/api/acceptance/payments/pay',
                [
                    'source' => [
                        'identifier'  => $request->input('number'),
                        'sourceholder_name' => $request->input('name'),
                        'subtype'     => 'CARD',
                        'cvn'         => $request->input('cvv'),
                        'expiry_month' => $request->input('month'),
                        'expiry_year'  => substr($request->input('year'), -2),
                    ],
                    'payment_token' => $paymentKey,
                ]
            );

            $chargeData = $chargeRes->json();
            $success = ($chargeData['success'] ?? false) === true || ($chargeData['pending'] ?? false) === false;

            $donation = Donation::create([
                'campaign_id'  => $request->input('campaign_id'),
                'donor_name'   => $request->input('name'),
                'donor_email'  => $request->input('email'),
                'amount'       => $request->input('amount'),
                'currency'     => $request->input('currency', 'USD'),
                'description'  => $request->input('description'),
                'status'       => $success ? 'success' : 'failed',
                'gateway_ref'  => $chargeData['id'] ?? null,
                'gateway_data' => $chargeData,
            ]);

            return response()->json([
                'success'       => $success,
                'donation_id'   => $donation->id,
                'campaign_name' => $this->getCampaignName($donation->campaign_id),
                'amount'        => $donation->amount,
                'currency'      => $donation->currency,
                'message'       => $chargeData['data']['message'] ?? ($success ? 'Payment successful' : 'Payment failed'),
            ]);

        } catch (\Exception $e) {
            Log::error('Paymob error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Paymob callback webhook
    public function callback(Request $request)
    {
        $settings  = $this->settings();
        $hmac      = $request->query('hmac');
        // Verify HMAC if needed
        Log::info('Paymob callback', $request->all());

        $success   = $request->input('success') === 'true';
        $ref       = $request->input('id');

        if ($ref) {
            Donation::where('gateway_ref', $ref)->update([
                'status' => $success ? 'success' : 'failed',
            ]);
        }
        return response('OK', 200);
    }

    private function getCampaignName(?int $id): string
    {
        if (!$id) return '';
        $campaign = Campaign::find($id);
        return $campaign?->title_ar ?? $campaign?->title ?? '';
    }
}
