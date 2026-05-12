<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\PaymobSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function process(Request $request, string $locale)
    {
        $settings = PaymobSetting::current();

        if ($settings->test_mode || !$settings->is_active) {
            return $this->handleTestMode($request);
        }

        return $this->handleLivePayment($request, $locale, $settings);
    }

    // ================================================================
    // Test Mode
    // ================================================================
    private function handleTestMode(Request $request)
    {
        $donation = Donation::create([
            'campaign_id'  => $request->input('campaign_id') ?: null,
            'name'         => $request->input('name') ?: 'Test User',
            'email'        => $request->input('email'),
            'amount'       => $request->input('amount', 0),
            'currency'     => $request->input('currency', 'USD'),
            'card_brand'   => $request->input('card_brand', 'unknown'),
            'description'  => $request->input('description'),
            'payment_method' => 'card',
            'status'       => 'success',
            'gateway_ref'  => 'TEST-' . strtoupper(Str::random(10)),
            'gateway_data' => ['test_mode' => true],
        ]);

        return response()->json([
            'success'       => true,
            'test_mode'     => true,
            'donation_id'   => $donation->id,
            'campaign_name' => $this->getCampaignName($donation->campaign_id),
            'amount'        => (float) $donation->amount,
            'currency'      => $donation->currency,
            'message'       => 'Test payment accepted',
        ]);
    }

    // ================================================================
    // Live Paymob — Intention API
    // ================================================================
    private function handleLivePayment(Request $request, string $locale, PaymobSetting $settings)
    {
        try {
            $amountCents = (int) round((float) $request->input('amount', 0) * 100);
            $currency    = strtoupper($request->input('currency', 'EGP'));

            if (str_contains($settings->base_url, 'oman')) {
                $amountCents = (int) round((float) $request->input('amount', 0) * 1000);
            }

            $specialRef = 'DON-' . time() . '-' . Str::random(6);

            $donation = Donation::create([
                'campaign_id'    => $request->input('campaign_id') ?: null,
                'name'           => $request->input('name'),
                'email'          => $request->input('email'),
                'amount'         => $request->input('amount'),
                'currency'       => $currency,
                'card_brand'     => $request->input('card_brand', 'unknown'),
                'description'    => $request->input('description'),
                'payment_method' => 'card',
                'status'         => 'pending',
                'gateway_ref'    => $specialRef,
            ]);

            $callbackUrl = $settings->callback_url ?: url($locale . '/donate/payment/callback');
            $redirectUrl = $settings->redirect_url ?: url($locale . '/donate/payment/result');

            $resp = Http::withHeaders([
                'Authorization' => 'Token ' . $settings->secret_key,
                'Content-Type'  => 'application/json',
            ])->post($settings->base_url . '/v1/intention/', [
                'amount'          => $amountCents,
                'currency'        => $currency,
                'payment_methods' => [(int) $settings->integration_id],
                'items' => [[
                    'name'        => $donation->description ?: 'Donation',
                    'amount'      => $amountCents,
                    'description' => $donation->description ?: 'Donation',
                    'quantity'    => 1,
                ]],
                'billing_data' => [
                    'first_name'   => $request->input('name', 'Donor'),
                    'last_name'    => 'N/A',
                    'email'        => $request->input('email', 'na@na.com'),
                    'phone_number' => '+10000000000',
                    'apartment'    => 'N/A', 'floor' => 'N/A',
                    'building'     => 'N/A', 'street' => 'N/A',
                    'city'         => 'N/A', 'country' => 'N/A',
                    'state'        => 'N/A', 'postal_code' => 'N/A',
                ],
                'special_reference' => $specialRef,
                'notification_url'  => $callbackUrl,
                'redirection_url'   => $redirectUrl . '?donation_id=' . $donation->id,
                'extras' => [
                    'donation_id'   => $donation->id,
                    'campaign_name' => $this->getCampaignName($donation->campaign_id),
                ],
            ]);

            if ($resp->failed()) {
                Log::error('Paymob intention failed', ['body' => $resp->body()]);
                return response()->json(['success' => false, 'message' => 'Gateway error: ' . $resp->status()], 422);
            }

            $clientSecret = $resp->json('client_secret');
            if (!$clientSecret) {
                return response()->json(['success' => false, 'message' => 'No client_secret from gateway'], 422);
            }

            $donation->update(['gateway_ref' => $clientSecret]);

            $checkoutUrl = $settings->base_url . '/unifiedcheckout/?publicKey='
                . $settings->public_key . '&clientSecret=' . $clientSecret;

            return response()->json([
                'success'      => true,
                'redirect'     => true,
                'checkout_url' => $checkoutUrl,
                'donation_id'  => $donation->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('Paymob exception: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ================================================================
    // GET /{locale}/donate/payment/result
    // ================================================================
    public function result(Request $request, string $locale)
    {
        $donationId = $request->query('donation_id');
        $txnSuccess = in_array($request->query('success', 'false'), ['true', '1']);
        $txnId      = $request->query('transaction_id', $request->query('id'));

        if ($donationId) {
            Donation::where('id', $donationId)->update([
                'status'       => $txnSuccess ? 'success' : 'failed',
                'transaction_id' => $txnId,
                'gateway_data' => $request->query(),
            ]);
        }

        $donation = $donationId ? Donation::find($donationId) : null;

        return view('pages.payment-result', [
            'success'      => $txnSuccess,
            'donation'     => $donation,
            'campaignName' => $this->getCampaignName($donation?->campaign_id),
            'locale'       => $locale,
            'isAr'         => $locale === 'ar',
        ]);
    }

    // ================================================================
    // POST /donate/payment/callback  (Paymob webhook)
    // ================================================================
    public function callback(Request $request)
    {
        $settings = PaymobSetting::current();
        Log::info('Paymob webhook', $request->all());

        if ($settings->hmac_secret) {
            $obj   = $request->all();
            $parts = [
                $obj['amount_cents']           ?? '',
                $obj['created_at']             ?? '',
                $obj['currency']               ?? '',
                $obj['error_occured']          ?? '',
                $obj['has_parent_transaction'] ?? '',
                $obj['id']                     ?? '',
                $obj['integration_id']         ?? '',
                $obj['is_3d_secure']           ?? '',
                $obj['is_auth']                ?? '',
                $obj['is_capture']             ?? '',
                $obj['is_refunded']            ?? '',
                $obj['is_standalone_payment']  ?? '',
                $obj['is_voided']              ?? '',
                $obj['order']                  ?? '',
                $obj['owner']                  ?? '',
                $obj['pending']                ?? '',
                $obj['source_data_pan']        ?? '',
                $obj['source_data_sub_type']   ?? '',
                $obj['source_data_type']       ?? '',
                $obj['success']                ?? '',
            ];
            $calculated = hash_hmac('sha512', implode('', $parts), $settings->hmac_secret);
            if (!hash_equals($calculated, $request->query('hmac', ''))) {
                return response('HMAC_FAIL', 401);
            }
        }

        $success    = in_array($request->input('success'), [true, 'true']);
        $txnId      = $request->input('id');
        $specialRef = $request->input('special_reference')
            ?? ($request->input('merchant_order_id') ?? null);

        if ($specialRef) {
            Donation::where('gateway_ref', $specialRef)->update([
                'status'         => $success ? 'success' : 'failed',
                'transaction_id' => (string) $txnId,
                'gateway_data'   => $request->all(),
            ]);
        }

        return response('OK', 200);
    }

    private function getCampaignName(?int $id): string
    {
        if (!$id) return '';
        $c = Campaign::find($id);
        return $c?->title_ar ?? $c?->title ?? '';
    }
}
