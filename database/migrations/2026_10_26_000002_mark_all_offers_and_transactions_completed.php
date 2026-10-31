<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Completes all remaining accepted offers/transactions (Kris Aquino and Abe Austria)
     * so that all 5 platform transactions are certified and marked 'Completed'.
     */
    public function up(): void
    {
        $transactionsToComplete = [
            // Kris Aquino (Offer #360004) -> iPad Pro 12.9" (Listing #360004) - Oct 16, 2026
            [
                'email' => 'krisaquino817@gmail.com',
                'offer_id' => 360004,
                'listing_id' => 360004,
                'bid_amount' => 8500.00,
                'pickup_time' => '2026-10-16 17:45:00',
                'completed_time' => '2026-10-16 18:00:00',
                'device_category' => 'Tablet',
                'device_weight' => 0.63,
                'co2_saved' => 1.45,
                'processing_method' => 'repair',
                'pickup_location' => 'San Carlos Town Plaza, San Carlos City',
            ],
            // Abe Austria (Offer #360005) -> Samsung Galaxy Tab S6 Lite (Listing #360005) - Oct 13, 2026
            [
                'email' => 'Abeaustria@gmail.com',
                'offer_id' => 360005,
                'listing_id' => 360005,
                'bid_amount' => 4500.00,
                'pickup_time' => '2026-10-13 18:20:00',
                'completed_time' => '2026-10-13 18:35:00',
                'device_category' => 'Tablet',
                'device_weight' => 0.47,
                'co2_saved' => 1.08,
                'processing_method' => 'harvest',
                'pickup_location' => 'Brgy. Mabini Crossing, San Carlos City',
            ],
        ];

        foreach ($transactionsToComplete as $item) {
            $buyer = DB::table('users')->where('email', $item['email'])->first();
            $offer = DB::table('offers')->where('id', $item['offer_id'])->first();
            if (!$offer && $buyer) {
                $offer = DB::table('offers')->where('buyer_id', $buyer->id)->first();
            }
            if (!$offer) {
                continue;
            }

            $listingId = $offer->listing_id;
            $listing = DB::table('listings')->where('id', $listingId)->first();
            $sellerId = $listing ? $listing->user_id : (DB::table('users')->where('email', 'seller@test.com')->value('id') ?? 1);
            $buyerId = $buyer ? $buyer->id : $offer->buyer_id;

            // 1. Mark Offer as completed
            DB::table('offers')->where('id', $offer->id)->update([
                'status' => 'completed',
                'cash_received_at' => $item['completed_time'],
                'proposed_pickup_date' => $item['pickup_time'],
                'updated_at' => $item['completed_time'],
            ]);

            // 2. Mark Listing as delivered / completed
            DB::table('listings')->where('id', $listingId)->update([
                'status' => 'delivered',
                'picked_up_at' => $item['pickup_time'],
                'delivered_at' => $item['completed_time'],
                'processed_at' => Carbon::parse($item['pickup_time'])->addHours(2)->toDateTimeString(),
                'updated_at' => $item['completed_time'],
            ]);

            // 3. Create or Update Impact Log
            if (Schema::hasTable('impact_logs')) {
                $existingImpact = DB::table('impact_logs')->where('offer_id', $offer->id)->first();
                $weight = $listing ? (float)$listing->estimated_weight : (float)$item['device_weight'];
                $co2 = $listing ? (float)$listing->carbon_footprint : (float)$item['co2_saved'];

                if (!$existingImpact) {
                    $certToken = 'CERT-' . strtoupper(Str::random(12));
                    DB::table('impact_logs')->insert([
                        'listing_id' => $listingId,
                        'offer_id' => $offer->id,
                        'seller_id' => $sellerId,
                        'buyer_id' => $buyerId,
                        'device_type_id' => $listing ? $listing->device_type_id : 4,
                        'device_category' => $item['device_category'],
                        'device_weight' => $weight,
                        'processing_method' => $item['processing_method'],
                        'co2_saved' => $co2,
                        'landfill_diverted_weight' => $weight,
                        'materials_recovered_weight' => round($weight * 0.85, 2),
                        'gold_recovered' => 0.0004,
                        'copper_recovered' => round($weight * 0.22, 2),
                        'aluminum_recovered' => round($weight * 0.35, 2),
                        'plastic_recovered' => round($weight * 0.28, 2),
                        'certificate_token' => $certToken,
                        'status' => 'certified',
                        'certified_at' => Carbon::parse($item['completed_time'])->addMinutes(20)->toDateTimeString(),
                        'created_at' => $item['completed_time'],
                        'updated_at' => $item['completed_time'],
                    ]);
                } else {
                    DB::table('impact_logs')->where('id', $existingImpact->id)->update([
                        'status' => 'certified',
                        'certified_at' => Carbon::parse($item['completed_time'])->addMinutes(20)->toDateTimeString(),
                        'created_at' => $item['completed_time'],
                        'updated_at' => $item['completed_time'],
                    ]);
                }
            }

            // 4. Create or Update Commission Record
            if (Schema::hasTable('commissions')) {
                $gross = (float)$item['bid_amount'];
                $rate = 5.00;
                $fee = round($gross * ($rate / 100), 2);
                $net = round($gross - $fee, 2);

                $existingComm = DB::table('commissions')->where('offer_id', $offer->id)->first();
                if (!$existingComm) {
                    DB::table('commissions')->insert([
                        'offer_id' => $offer->id,
                        'payment_id' => null,
                        'seller_id' => $sellerId,
                        'buyer_id' => $buyerId,
                        'gross_amount' => $gross,
                        'commission_rate' => $rate,
                        'commission_amount' => $fee,
                        'seller_net_amount' => $net,
                        'payment_method' => 'cash_pickup',
                        'status' => 'collected',
                        'collected_at' => $item['completed_time'],
                        'notes' => "Platform commission for completed handover #{$offer->id}",
                        'created_at' => $item['completed_time'],
                        'updated_at' => $item['completed_time'],
                    ]);
                } else {
                    DB::table('commissions')->where('id', $existingComm->id)->update([
                        'status' => 'collected',
                        'collected_at' => $item['completed_time'],
                        'updated_at' => $item['completed_time'],
                    ]);
                }
            }

            // 5. Update Audit Logs
            if (Schema::hasTable('audit_logs')) {
                DB::table('audit_logs')->updateOrInsert(
                    [
                        'model_type' => 'Listing',
                        'model_id' => $listingId,
                        'action' => 'item_picked_up',
                    ],
                    [
                        'user_id' => $sellerId,
                        'description' => "Listing #{$listingId} handed over to " . ($buyer ? $buyer->name : 'Buyer') . " at {$item['pickup_location']}",
                        'ip_address' => '136.158.12.83',
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                        'created_at' => $item['pickup_time'],
                        'updated_at' => $item['pickup_time'],
                    ]
                );

                DB::table('audit_logs')->updateOrInsert(
                    [
                        'model_type' => 'Offer',
                        'model_id' => $offer->id,
                        'action' => 'transaction_completed',
                    ],
                    [
                        'user_id' => $buyerId,
                        'description' => "Transaction #{$offer->id} completed. {$item['device_weight']} kg diverted from landfill ({$item['co2_saved']} kg CO₂ saved)",
                        'ip_address' => '120.28.9.44',
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                        'created_at' => $item['completed_time'],
                        'updated_at' => $item['completed_time'],
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op
    }
};
