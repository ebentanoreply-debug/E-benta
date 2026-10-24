<?php

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Removes all offers/transactions EXCEPT those where the seller is Test Seller (seller@test.com).
     */
    public function up(): void
    {
        if (!Schema::hasTable('offers')) {
            return;
        }

        // 1. Identify Test Seller IDs
        $testSellerIds = User::where('email', 'seller@test.com')
            ->orWhere('name', 'Test Seller')
            ->pluck('id')
            ->filter()
            ->toArray();

        // 2. Query offers to delete:
        // Any offer where the associated listing does NOT belong to Test Seller
        $offersQuery = Offer::withTrashed();

        if (!empty($testSellerIds)) {
            $offersQuery->whereDoesntHave('listing', function ($q) use ($testSellerIds) {
                $q->whereIn('user_id', $testSellerIds);
            });
        }

        $offersToRemove = $offersQuery->get();

        if ($offersToRemove->isEmpty()) {
            return;
        }

        $offerIds = $offersToRemove->pluck('id')->toArray();
        $listingIds = $offersToRemove->pluck('listing_id')->filter()->unique()->toArray();

        // 3. Remove dependent records safely
        if (Schema::hasTable('commissions')) {
            DB::table('commissions')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('payments')) {
            DB::table('payments')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('wallet_transactions')) {
            DB::table('wallet_transactions')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('reviews')) {
            DB::table('reviews')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('messages')) {
            DB::table('messages')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('impact_logs')) {
            DB::table('impact_logs')->whereIn('offer_id', $offerIds)->delete();
        }

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')
                ->where('model_type', 'Offer')
                ->whereIn('model_id', $offerIds)
                ->delete();
        }

        if (Schema::hasTable('notifications')) {
            foreach ($offerIds as $oid) {
                DB::table('notifications')
                    ->where('data->offer_id', $oid)
                    ->orWhere('data', 'like', '%"offer_id":' . $oid . '%')
                    ->orWhere('data', 'like', '%"offer_id": "' . $oid . '"%')
                    ->delete();
            }
        }

        // 4. Reset listing status for listings that no longer have active offers
        if (Schema::hasTable('listings')) {
            foreach ($listingIds as $listingId) {
                $hasRemainingOffers = Offer::where('listing_id', $listingId)
                    ->whereNotIn('id', $offerIds)
                    ->exists();

                if (!$hasRemainingOffers) {
                    DB::table('listings')->where('id', $listingId)->update([
                        'status' => 'available',
                        'matched_buyer_id' => null,
                        'matched_at' => null,
                        'pickup_scheduled_at' => null,
                        'picked_up_at' => null,
                        'delivered_at' => null,
                        'processed_at' => null,
                    ]);

                    if (Schema::hasTable('audit_logs')) {
                        DB::table('audit_logs')
                            ->where('model_type', 'Listing')
                            ->where('model_id', $listingId)
                            ->where('action', 'item_picked_up')
                            ->delete();
                    }
                }
            }
        }

        // 5. Delete the offers permanently
        DB::table('offers')->whereIn('id', $offerIds)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to preserve state
    }
};
