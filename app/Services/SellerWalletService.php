<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PayoutRequest;
use App\Models\SellerWallet;
use Illuminate\Support\Facades\DB;

class SellerWalletService
{
    public function walletForSeller(int $sellerId): SellerWallet
    {
        return SellerWallet::firstOrCreate(['user_id' => $sellerId]);
    }

    public function creditPaidPayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $payment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();

            if ($payment->status === 'paid') {
                return;
            }

            $wallet = SellerWallet::where('user_id', $payment->seller_id)->lockForUpdate()->first()
                ?: SellerWallet::create(['user_id' => $payment->seller_id]);

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $wallet->available_balance = (float) $wallet->available_balance + (float) $payment->net_amount;
            $wallet->save();

            $wallet->transactions()->create([
                'offer_id' => $payment->offer_id,
                'payment_id' => $payment->id,
                'type' => 'sale_credit',
                'amount' => $payment->net_amount,
                'balance_after' => $wallet->available_balance,
                'status' => 'posted',
                'description' => 'Sale credit for offer #' . $payment->offer_id . ' (Gross: ₱' . number_format($payment->amount, 2) . ', Commission: ₱' . number_format($payment->fee_amount, 2) . ')',
            ]);

            app(CommissionService::class)->recordOnlineCommission($payment);
        });
    }

    public function requestPayout(SellerWallet $wallet, float $amount, string $destinationType, ?string $destinationLabel): PayoutRequest
    {
        return DB::transaction(function () use ($wallet, $amount, $destinationType, $destinationLabel) {
            $wallet = SellerWallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();

            if ((float) $wallet->available_balance < $amount) {
                throw new \RuntimeException('Insufficient wallet balance.');
            }

            $wallet->available_balance = (float) $wallet->available_balance - $amount;
            $wallet->pending_balance = (float) $wallet->pending_balance + $amount;
            $wallet->save();

            $payout = PayoutRequest::create([
                'seller_id' => $wallet->user_id,
                'seller_wallet_id' => $wallet->id,
                'amount' => $amount,
                'status' => 'pending',
                'destination_type' => $destinationType,
                'destination_label' => $destinationLabel,
                'requested_at' => now(),
            ]);

            $wallet->transactions()->create([
                'payout_request_id' => $payout->id,
                'type' => 'payout_hold',
                'amount' => -$amount,
                'balance_after' => $wallet->available_balance,
                'status' => 'posted',
                'description' => 'Payout request #' . $payout->id . ' placed on hold',
            ]);

            return $payout;
        });
    }
}
