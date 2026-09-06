<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Payment;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payOffer(Request $request, Offer $offer, PayMongoService $payMongo)
    {
        if (Auth::id() !== $offer->buyer_id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if ($offer->status !== 'accepted') {
            return redirect()->back()->with('error', 'Only accepted offers can be paid.');
        }

        if ($offer->payments()->where('status', 'paid')->exists()) {
            return redirect()->back()->with('info', 'This offer has already been paid.');
        }

        $baseUrl = rtrim($request->getSchemeAndHttpHost(), '/');
        $existingPending = $offer->payments()->where('status', 'pending')->latest()->first();
        if (
            $existingPending?->checkout_url
            && data_get($existingPending->payload, '_callback_base_url') === $baseUrl
        ) {
            return redirect()->away($existingPending->checkout_url);
        }

        $feePercent = (float) config('services.paymongo.platform_fee_percent', 0);
        $amount = (float) $offer->bid_amount;
        $feeAmount = round($amount * ($feePercent / 100), 2);
        $netAmount = $amount - $feeAmount;

        $payment = Payment::create([
            'offer_id' => $offer->id,
            'buyer_id' => $offer->buyer_id,
            'seller_id' => $offer->listing->user_id,
            'amount' => $amount,
            'fee_amount' => $feeAmount,
            'net_amount' => $netAmount,
            'status' => 'pending',
        ]);

        try {
            $session = $payMongo->createCheckoutSession($offer, $baseUrl);
            $attributes = $session['attributes'] ?? [];

            $payment->update([
                'paymongo_checkout_session_id' => $session['id'] ?? null,
                'checkout_url' => $attributes['checkout_url'] ?? null,
                'payload' => array_merge($session, ['_callback_base_url' => $baseUrl]),
            ]);
        } catch (\Throwable $e) {
            $payment->update([
                'status' => 'failed',
                'failed_at' => now(),
            ]);

            return redirect()->back()->with('error', $e->getMessage());
        }

        if (!$payment->checkout_url) {
            return redirect()->back()->with('error', 'PayMongo did not return a checkout URL.');
        }

        return redirect()->away($payment->checkout_url);
    }

    public function success(Request $request)
    {
        return redirect()
            ->route('offers.show', $request->query('offer'))
            ->with('success', 'Payment submitted. We will update the offer once PayMongo confirms it.');
    }

    public function failed(Request $request)
    {
        return redirect()
            ->route('offers.show', $request->query('offer'))
            ->with('error', 'Payment was cancelled or did not complete.');
    }
}
