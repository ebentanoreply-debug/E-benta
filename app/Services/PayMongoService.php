<?php

namespace App\Services;

use App\Models\Offer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PayMongoService
{
    public function createCheckoutSession(Offer $offer): array
    {
        $baseUrl = rtrim(config('app.url'), '/');
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

    public function webhookSignatureIsValid(string $payload, ?string $signatureHeader): bool
    {
        $secret = config('services.paymongo.webhook_secret');

        if (!$secret) {
            return true;
        }

        if (!$signatureHeader) {
            return false;
        }

        foreach (explode(',', $signatureHeader) as $part) {
            $part = trim($part);
            if (Str::startsWith($part, 'te=')) {
                $signature = substr($part, 3);
                if (hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
                    return true;
                }
            }
        }

        return false;
    }
}
