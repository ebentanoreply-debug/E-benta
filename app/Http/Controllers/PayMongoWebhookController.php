<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PayMongoService;
use App\Services\SellerWalletService;
use Illuminate\Http\Request;

class PayMongoWebhookController extends Controller
{
    public function handle(Request $request, PayMongoService $payMongo, SellerWalletService $wallets)
    {
        $payload = $request->getContent();
        $signature = $request->header('Paymongo-Signature') ?: $request->header('paymongo-signature');

        if (!$payMongo->webhookSignatureIsValid($payload, $signature)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $event = $request->input('data.attributes.type');
        $data = $request->input('data.attributes.data');
        $attributes = $data['attributes'] ?? [];
        $metadata = $attributes['metadata'] ?? [];

        $payment = null;
        $checkoutId = $data['id'] ?? null;
        $paymentIntentId = $attributes['payment_intent_id'] ?? ($attributes['payment_intent']['id'] ?? null);
        $paymentId = $attributes['payments'][0]['id'] ?? ($data['id'] ?? null);

        if ($checkoutId) {
            $payment = Payment::where('paymongo_checkout_session_id', $checkoutId)->first();
        }

        if (!$payment && !empty($metadata['offer_id'])) {
            $payment = Payment::where('offer_id', $metadata['offer_id'])
                ->where('status', 'pending')
                ->latest()
                ->first();
        }

        if (!$payment) {
            return response()->json(['message' => 'No local payment matched.']);
        }

        $payment->update([
            'paymongo_payment_intent_id' => $paymentIntentId,
            'paymongo_payment_id' => $paymentId,
            'payload' => $request->input('data'),
        ]);

        if (in_array($event, ['checkout_session.payment.paid', 'payment.paid'], true)) {
            $wallets->creditPaidPayment($payment);
        }

        if (in_array($event, ['checkout_session.payment.failed', 'payment.failed'], true) && $payment->status !== 'paid') {
            $payment->update([
                'status' => 'failed',
                'failed_at' => now(),
            ]);
        }

        return response()->json(['received' => true]);
    }
}
