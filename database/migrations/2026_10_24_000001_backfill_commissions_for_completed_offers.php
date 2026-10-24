<?php

use App\Models\Commission;
use App\Models\Offer;
use App\Services\CommissionService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Backfills platform commission records for all completed offers that lack one.
     */
    public function up(): void
    {
        if (!Schema::hasTable('commissions') || !Schema::hasTable('offers')) {
            return;
        }

        $completedOffers = Offer::where('status', 'completed')
            ->with(['listing'])
            ->get();

        $commissionService = app(CommissionService::class);
        $rate = $commissionService->getCommissionRate();

        foreach ($completedOffers as $offer) {
            // Ensure payment method is assigned
            if (empty($offer->payment_method)) {
                $offer->update(['payment_method' => 'cash_pickup']);
            }

            // Avoid duplicate commissions
            $exists = Commission::where('offer_id', $offer->id)->exists();
            if ($exists) {
                continue;
            }

            $sellerId = $offer->listing?->user_id;
            $buyerId = $offer->buyer_id;

            if (!$sellerId || !$buyerId) {
                continue;
            }

            $calc = $commissionService->calculate((float) $offer->bid_amount, $rate);
            $collectedAt = $offer->updated_at ?? $offer->created_at ?? now();

            Commission::create([
                'offer_id' => $offer->id,
                'payment_id' => null,
                'seller_id' => $sellerId,
                'buyer_id' => $buyerId,
                'gross_amount' => $calc['gross_amount'],
                'commission_rate' => $calc['rate'],
                'commission_amount' => $calc['commission_amount'],
                'seller_net_amount' => $calc['net_amount'],
                'payment_method' => $offer->payment_method ?: 'cash_pickup',
                'status' => 'collected',
                'collected_at' => $collectedAt,
                'notes' => 'Platform commission for completed trade #' . $offer->id,
                'created_at' => $collectedAt,
                'updated_at' => $collectedAt,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to preserve financial audit trail
    }
};
