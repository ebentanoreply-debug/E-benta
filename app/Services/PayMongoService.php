<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayMongoService
{
    public function createCheckoutSession(Offer $offer, string $baseUrl): array
    {
        $baseUrl = rtrim($baseUrl, '/');
        $amount = (int) round(((float) $offer->bid_amount) * 100);

        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'amount' => $amount,
                        'currency' => 'PHP',
                        'description' => 'E-Benta Offer #' . $offer->id,
                        'line_items' => [[
                            'currency' => 'PHP',
                            'amount' => $amount,
                            'name' => $offer->listing?->category ?: 'E-Benta listing',
                            'quantity' => 1,
                        ]],
                        'payment_method_types' => config('services.paymongo.payment_methods', ['gcash', 'grab_pay', 'paymaya', 'card']),
                        'success_url' => $baseUrl . '/payments/success?offer=' . $offer->id,
                        'cancel_url' => $baseUrl . '/payments/failed?offer=' . $offer->id,
                        'metadata' => [
                            'offer_id' => (string) $offer->id,
                            'buyer_id' => (string) $offer->buyer_id,
                            'seller_id' => (string) $offer->listing->user_id,
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException($response->json('errors.0.detail') ?? 'Unable to create PayMongo checkout session.');
        }

        return $response->json('data');
    }

    public function getCheckoutSession(string $checkoutSessionId): array
    {
        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->acceptJson()
            ->get("https://api.paymongo.com/v1/checkout_sessions/{$checkoutSessionId}");

        if ($response->failed()) {
            throw new \RuntimeException($response->json('errors.0.detail') ?? 'Unable to retrieve PayMongo checkout session.');
        }

        return $response->json('data') ?? [];
    }

    /**
     * Synchronize a pending payment with PayMongo checkout session status.
     * Marks payment as paid and credits seller wallet if payment has succeeded.
     */
    public function syncPaymentStatus(Payment $payment, SellerWalletService $wallets): bool
    {
        if ($payment->status === 'paid') {
            return true;
        }

        if (!$payment->paymongo_checkout_session_id) {
            return false;
        }

        try {
            $session = $this->getCheckoutSession($payment->paymongo_checkout_session_id);
            $attributes = $session['attributes'] ?? [];
            $payments = $attributes['payments'] ?? [];
            $paymentIntent = $attributes['payment_intent'] ?? [];
            $sessionStatus = $attributes['status'] ?? null;

            $isPaid = $sessionStatus === 'paid'
                || !empty($payments)
                || ($paymentIntent['attributes']['status'] ?? null) === 'succeeded';

            if ($isPaid) {
                $paymentIntentId = $paymentIntent['id'] ?? null;
                $paymentId = $payments[0]['id'] ?? null;

                $payment->update([
                    'paymongo_payment_intent_id' => $paymentIntentId ?: $payment->paymongo_payment_intent_id,
                    'paymongo_payment_id' => $paymentId ?: $payment->paymongo_payment_id,
                    'payload' => $session,
                ]);

                $wallets->creditPaidPayment($payment);

                return true;
            }

            if (in_array($sessionStatus, ['expired', 'cancelled'], true)) {
                $payment->update([
                    'status' => 'failed',
                    'failed_at' => now(),
                    'payload' => $session,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to sync PayMongo payment #' . $payment->id . ': ' . $e->getMessage());
        }

        return false;
    }

    public function webhookSignatureIsValid(string $payload, ?string $signatureHeader): bool
    {
        $secret = config('services.paymongo.webhook_secret');

        if (!$secret) {
            return true;
        }

        if (!$signatureHeader) {
            return false;
        }

        $timestamp = null;
        $signatures = [];

        foreach (explode(',', $signatureHeader) as $part) {
            $part = trim($part);
            if (Str::startsWith($part, 't=')) {
                $timestamp = substr($part, 2);
            } elseif (Str::startsWith($part, 'te=')) {
                $signatures['te'] = substr($part, 3);
            } elseif (Str::startsWith($part, 'li=')) {
                $signatures['li'] = substr($part, 3);
            }
        }

        if (!$timestamp || empty($signatures)) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expectedSignature, $signature)) {
                return true;
            }
        }

        return false;
    }
}
