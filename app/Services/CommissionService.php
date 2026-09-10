<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\PlatformSetting;
use App\Models\SellerWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CommissionService
{
    /**
     * Default platform commission rate in percent if not configured.
     */
    public const DEFAULT_COMMISSION_RATE = 5.0;

    /**
     * Retrieve current platform commission percentage.
     */
    public function getCommissionRate(): float
    {
        $settingRate = PlatformSetting::get('commission_rate_percent');

        if ($settingRate !== null && is_numeric($settingRate)) {
            return (float) $settingRate;
        }

        $configFee = config('services.paymongo.platform_fee_percent');
        if ($configFee !== null && is_numeric($configFee) && (float) $configFee > 0) {
            return (float) $configFee;
        }

        return self::DEFAULT_COMMISSION_RATE;
    }

    /**
     * Check if commission deduction applies to cash on pickup.
     */
    public function isCashCommissionEnabled(): bool
    {
        return (bool) PlatformSetting::get('cash_pickup_commission_enabled', true);
    }

    /**
     * Calculate commission breakdown for a given gross amount.
     */
    public function calculate(float $grossAmount, ?float $customRate = null): array
    {
        $rate = $customRate !== null ? $customRate : $this->getCommissionRate();
        $grossAmount = max(0, round($grossAmount, 2));
        $commissionAmount = round($grossAmount * ($rate / 100), 2);
        $netAmount = max(0, round($grossAmount - $commissionAmount, 2));

        return [
            'rate' => $rate,
            'gross_amount' => $grossAmount,
            'commission_amount' => $commissionAmount,
            'net_amount' => $netAmount,
        ];
    }

    /**
     * Record a commission for a successfully paid online PayMongo transaction.
     */
    public function recordOnlineCommission(Payment $payment): ?Commission
    {
        if (!Schema::hasTable('commissions')) {
            return null;
        }

        $existing = Commission::where('payment_id', $payment->id)->first();
        if ($existing) {
            return $existing;
        }

        $gross = (float) $payment->amount;
        $fee = (float) $payment->fee_amount;
        $rate = $gross > 0 ? round(($fee / $gross) * 100, 2) : $this->getCommissionRate();
        $net = (float) $payment->net_amount;

        return Commission::create([
            'offer_id' => $payment->offer_id,
            'payment_id' => $payment->id,
            'seller_id' => $payment->seller_id,
            'buyer_id' => $payment->buyer_id,
            'gross_amount' => $gross,
            'commission_rate' => $rate,
            'commission_amount' => $fee,
            'seller_net_amount' => $net,
            'payment_method' => 'paymongo',
            'status' => 'collected',
            'collected_at' => $payment->paid_at ?: now(),
            'notes' => 'Platform commission automatically retained from online payment #' . $payment->id,
        ]);
    }

    /**
     * Record and deduct commission for a Cash on Pickup transaction when seller confirms receipt.
     */
    public function processCashCommission(Offer $offer): ?Commission
    {
        if (!Schema::hasTable('commissions') || !$this->isCashCommissionEnabled()) {
            return null;
        }

        // Avoid duplicate commissions for the same offer
        $existing = Commission::where('offer_id', $offer->id)
            ->where('payment_method', 'cash_pickup')
            ->first();

        if ($existing) {
            return $existing;
        }

        $calc = $this->calculate((float) $offer->bid_amount);
        $commissionAmount = $calc['commission_amount'];

        if ($commissionAmount <= 0) {
            return null;
        }

        return DB::transaction(function () use ($offer, $calc, $commissionAmount) {
            $sellerId = $offer->listing->user_id;

            // Update seller wallet
            $wallet = SellerWallet::firstOrCreate(['user_id' => $sellerId]);
            $wallet = SellerWallet::whereKey($wallet->id)->lockForUpdate()->first();

            $wallet->available_balance = (float) $wallet->available_balance - $commissionAmount;
            $wallet->save();

            // Record wallet transaction
            $wallet->transactions()->create([
                'offer_id' => $offer->id,
                'type' => 'platform_fee',
                'amount' => -$commissionAmount,
                'balance_after' => $wallet->available_balance,
                'status' => 'posted',
                'description' => 'Platform fee (' . $calc['rate'] . '%) for Cash on Pickup offer #' . $offer->id,
            ]);

            return Commission::create([
                'offer_id' => $offer->id,
                'payment_id' => null,
                'seller_id' => $sellerId,
                'buyer_id' => $offer->buyer_id,
                'gross_amount' => $calc['gross_amount'],
                'commission_rate' => $calc['rate'],
                'commission_amount' => $commissionAmount,
                'seller_net_amount' => $calc['net_amount'],
                'payment_method' => 'cash_pickup',
                'status' => 'collected',
                'collected_at' => now(),
                'notes' => 'Commission deducted from seller wallet upon cash handover confirmation',
            ]);
        });
    }

    /**
     * Aggregated platform revenue and performance statistics for Admin.
     */
    public function getRevenueStatistics(): array
    {
        if (!Schema::hasTable('commissions')) {
            return [
                'total_commission' => 0.0,
                'total_gmv' => 0.0,
                'commission_count' => 0,
                'avg_commission' => 0.0,
                'month_commission' => 0.0,
                'paymongo_commission' => 0.0,
                'cash_commission' => 0.0,
            ];
        }

        $collected = Commission::where('status', 'collected');

        $totalCommission = (float) (clone $collected)->sum('commission_amount');
        $totalGmv = (float) (clone $collected)->sum('gross_amount');
        $count = (clone $collected)->count();
        $avgCommission = $count > 0 ? round($totalCommission / $count, 2) : 0.0;

        $monthCommission = (float) (clone $collected)
            ->whereYear('collected_at', now()->year)
            ->whereMonth('collected_at', now()->month)
            ->sum('commission_amount');

        $paymongoCommission = (float) (clone $collected)
            ->where('payment_method', 'paymongo')
            ->sum('commission_amount');

        $cashCommission = (float) (clone $collected)
            ->where('payment_method', 'cash_pickup')
            ->sum('commission_amount');

        return [
            'total_commission' => $totalCommission,
            'total_gmv' => $totalGmv,
            'commission_count' => $count,
            'avg_commission' => $avgCommission,
            'month_commission' => $monthCommission,
            'paymongo_commission' => $paymongoCommission,
            'cash_commission' => $cashCommission,
        ];
    }
}
