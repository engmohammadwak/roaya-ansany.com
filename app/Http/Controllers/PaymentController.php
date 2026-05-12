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
    // ================================================================
    // POST /{locale}/donate/payment/3d/form
    // Receives form data → creates Paymob Intention → redirects to checkout
    // OR in test mode: simulates success and returns JSON
    // ================================================================
    public function process(Request $request, string $locale)
    {
        $settings = PaymobSetting::current();

        // ── Test Mode: simulate payment without gateway ──
        if ($settings->test_mode || !$settings->is_active) {
            return $this->handleTestMode($request, $locale);
        }

        // ── Real Paymob Intention API ──
        return $this->handleLivePayment($request, $locale, $settings);
    }

    // ================================================================
    // Test Mode
    // ================================================================
    private function handleTestMode(Request $request, string $locale)
    {
        $donation = Donation::create([
            'campaign_id'  => $request->input('campaign_id') ?: null,
            'donor_name'   => $request->input('name', 'Test User'),
            'donor_email'  => $request->input('email'),
            'amount'       => $request->input('amount', 0),
            'currency'     => $request->input('currency', 'USD'),
            'card_brand'   => $request->input('card_brand', 'unknown'),
            'description'  => $request->input('description'),
            'status'       => 'success',
            'gateway_ref'  => 'TEST-' . strtoupper(Str::random(10)),
            'gateway_data' => ['test_mode' => true],
        ]);

        return response()->json([
            'success'       => true,
            'test_mode'     => true,
            'donation_id'   => $donation->id,
            'campaign_name' => $this->getCampaignName($donation->campaign_id),
            'amount'        => $donation->amount,
            'currency'      => $donation->currency,
            'message'       => 'Test payment accepted',
        ]);
    }

    // ================================================================
    // Live Paymob — Intention API flow
    // Step 1: POST /v1/intention/ with secret_key
    // Step 2: Redirect to /unifiedcheckout/?publicKey=...&clientSecret=...
    // ================================================================
    private function handleLivePayment(Request $request, string $locale, PaymobSetting $settings)
    {
        try {
            $amountCents = (int) round((float) $request->input('amount', 0) * 100);
            $currency    = strtoupper($request->input('currency', 'EGP'));
            // Oman uses 1000 (3 decimal places)
            if (str_contains($settings->base_url, 'oman')) {
                $amountCents = (int) round((float) $request->input('amount', 0) * 1000);
            }

            $specialRef  = 'DON-' . time() . '-' . Str::random(6);

            // Save as pending first
            $donation = Donation::create([
                'campaign_id'  => $request->input('campaign_id') ?: null,
                'donor_name'   => $request->input('name'),
                'donor_email'  => $request->input('email'),
                'amount'       => $request->input('amount'),
                'currency'     => $currency,
                'card_brand'   => $request->input('card_brand', 'unknown'),
                'description'  => $request->input('description'),
                'status'       => 'pending',
                'gateway_ref'  => $specialRef,
            ]);

            // Callback & redirect URLs
            $callbackUrl = $settings->callback_url
                ?: url($locale . '/donate/payment/callback');
            $redirectUrl = $settings->redirect_url
                ?: url($locale . '/donate/payment/result');

            // Create Intention
            $resp = Http::withHeaders([
                'Authorization' => 'Token ' . $settings->secret_key,
                'Content-Type'  => 'application/json',
            ])->post($settings->base_url . '/v1/intention/', [
                'amount'          => $amountCents,
                'currency'        => $currency,
                'payment_methods' => [(int) $settings->integration_id],
                'items'           => [[
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
                    'apartment'    => 'N/A',
                    'floor'        => 'N/A',
                    'building'     => 'N/A',
                    'street'       => 'N/A',
                    'city'         => 'N/A',
                    'country'      => 'N/A',
                    'state'        => 'N/A',
                    'postal_code'  => 'N/A',
                ],
                'special_reference'    => $specialRef,
                'notification_url'     => $callbackUrl,
                'redirection_url'      => $redirectUrl . '?donation_id=' . $donation->id,
                'extras' => [
                    'donation_id'   => $donation->id,
                    'campaign_id'   => $donation->campaign_id,
                    'campaign_name' => $this->getCampaignName($donation->campaign_id),
                ],
            ]);

            if ($resp->failed()) {
                Log::error('Paymob intention failed', ['body' => $resp->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gateway error: ' . ($resp->json('message') ?? $resp->status()),
                ], 422);
            }

            $clientSecret = $resp->json('client_secret');
            if (!$clientSecret) {
                return response()->json([
                    'success' => false,
                    'message' => 'No client_secret returned from gateway',
                ], 422);
            }

            // Update donation with client_secret
            $donation->update(['gateway_ref' => $clientSecret]);

            // Return checkout URL for JS to redirect
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
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ================================================================
    // GET /{locale}/donate/payment/result
    // Paymob redirects customer here after payment
    // ================================================================
    public function result(Request $request, string $locale)
    {
        $donationId = $request->query('donation_id');
        $txnSuccess = $request->query('success', 'false') === 'true'
            || $request->query('is_success', 'false') === 'true';
        $txnId      = $request->query('transaction_id', $request->query('id'));

        if ($donationId) {
            Donation::where('id', $donationId)->update([
                'status'       => $txnSuccess ? 'success' : 'failed',
                'gateway_ref'  => $txnId ?? null,
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
    // POST /{locale}/donate/payment/callback  (webhook)
    // ================================================================
    public function callback(Request $request)
    {
        $settings = PaymobSetting::current();
        Log::info('Paymob webhook', $request->all());

        // Verify HMAC
        if ($settings->hmac_secret) {
            $receivedHmac = $request->query('hmac', '');
            // Build concatenated string per Paymob docs
            $obj   = $request->all();
            $parts = [
                $obj['amount_cents']      ?? '',
                $obj['created_at']        ?? '',
                $obj['currency']          ?? '',
                $obj['error_occured']     ?? '',
                $obj['has_parent_transaction'] ?? '',
                $obj['id']                ?? '',
                $obj['integration_id']    ?? '',
                $obj['is_3d_secure']      ?? '',
                $obj['is_auth']           ?? '',
                $obj['is_capture']        ?? '',
                $obj['is_refunded']       ?? '',
                $obj['is_standalone_payment'] ?? '',
                $obj['is_voided']         ?? '',
                $obj['order']             ?? '',
                $obj['owner']             ?? '',
                $obj['pending']           ?? '',
                $obj['source_data_pan']   ?? '',
                $obj['source_data_sub_type'] ?? '',
                $obj['source_data_type']  ?? '',
                $obj['success']           ?? '',
            ];
            $calculated = hash_hmac('sha512', implode('', $parts), $settings->hmac_secret);
            if (!hash_equals($calculated, $receivedHmac)) {
                Log::warning('Paymob HMAC mismatch');
                return response('HMAC_FAIL', 401);
            }
        }

        $success   = ($request->input('success') === true || $request->input('success') === 'true');
        $orderId   = $request->input('order');
        $txnId     = $request->input('id');

        // Match by special_reference stored in extras
        $specialRef = $request->input('special_reference')
            ?? ($request->input('order_data') ? ($request->input('order_data')['merchant_order_id'] ?? null) : null);

        if ($specialRef) {
            Donation::where('gateway_ref', $specialRef)->update([
                'status'      => $success ? 'success' : 'failed',
                'gateway_ref' => (string) $txnId,
                'gateway_data'=> $request->all(),
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
