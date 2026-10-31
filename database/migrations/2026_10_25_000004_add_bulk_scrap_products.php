<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Seeds realistic bulk e-waste scrap lots (smartphones & tablets) into listings and audit logs.
     */
    public function up(): void
    {
        if (!Schema::hasTable('listings')) {
            return;
        }

        // 1. Identify or create device_type_id for Smartphone and Tablet
        $smartphoneTypeId = DB::table('device_types')->where('name', 'Smartphone')->value('id');
        if (!$smartphoneTypeId) {
            $smartphoneTypeId = DB::table('device_types')->insertGetId([
                'name' => 'Smartphone',
                'icon' => 'fa-mobile-alt',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $tabletTypeId = DB::table('device_types')->where('name', 'Tablet')->value('id');
        if (!$tabletTypeId) {
            $tabletTypeId = DB::table('device_types')->insertGetId([
                'name' => 'Tablet',
                'icon' => 'fa-tablet-alt',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Fallback seller ID
        $fallbackSellerId = DB::table('users')->where('role', 'seller')->value('id')
            ?? DB::table('users')->value('id')
            ?? 1;

        // 3. Define bulk lots of common e-waste (phones & tablets)
        $bulkLots = [
            [
                'seller_email' => 'melicanjimboy12@gmail.com',
                'device_type_id' => $smartphoneTypeId,
                'secondary_type_ids' => [$smartphoneTypeId],
                'device_details' => 'Bulk Lot: 10x Assorted Android Phones',
                'lot_item_count' => 10,
                'condition' => 'minor_damage',
                'description' => 'Lot of 10 assorted Android smartphones (Samsung, Xiaomi, Vivo, and OPPO). 6 units power on with cracked screens or battery degradation; 4 units for parts and board-level harvesting. Ideal for tech recyclers and repair technicians.',
                'estimated_weight' => 1.85,
                'carbon_footprint' => 4.26,
                'suggested_price' => 1500.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'created_at' => '2026-10-14 10:15:00',
            ],
            [
                'seller_email' => 'canosejoseph248@gmail.com',
                'device_type_id' => $tabletTypeId,
                'secondary_type_ids' => [$tabletTypeId],
                'device_details' => 'Bulk Lot: 5x Defective School Tablets',
                'lot_item_count' => 5,
                'condition' => 'non_functional',
                'description' => 'Bundle of 5 defective educational and budget Android tablets (Lenovo Tab M10, Samsung Tab A, Huawei MatePad). Cracked touchscreens and depleted lithium cells. Motherboards, aluminum chassis, and copper shielding intact for scrap extraction.',
                'estimated_weight' => 2.35,
                'carbon_footprint' => 5.41,
                'suggested_price' => 1100.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'created_at' => '2026-10-15 13:40:00',
            ],
            [
                'seller_email' => 'markyvangarcia@gmail.com',
                'device_type_id' => $smartphoneTypeId,
                'secondary_type_ids' => [$smartphoneTypeId],
                'device_details' => 'Bulk Lot: 8x Old Smartphones',
                'lot_item_count' => 8,
                'condition' => 'minor_damage',
                'description' => '8 units of older model Samsung Galaxy J-series and Xiaomi Redmi handsets. 5 units power on with cosmetic scratches and worn charging pins. Complete with lithium batteries for safe e-waste disposition.',
                'estimated_weight' => 1.48,
                'carbon_footprint' => 3.40,
                'suggested_price' => 1350.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'created_at' => '2026-10-16 09:20:00',
            ],
            [
                'seller_email' => 'miashielagraceuson@gmail.com',
                'device_type_id' => $smartphoneTypeId,
                'secondary_type_ids' => [$smartphoneTypeId],
                'device_details' => 'Bulk Lot: 15x Depleted & Broken Smartphones Scrap Bundle',
                'lot_item_count' => 15,
                'condition' => 'non_functional',
                'description' => 'Scrap bundle of 15 broken mobile devices collected across barangays. Non-powering logic boards, cracked glass, and scrap chassis. Sorted for precious metals, copper coil, and safe battery disposal.',
                'estimated_weight' => 2.70,
                'carbon_footprint' => 6.21,
                'suggested_price' => 900.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'created_at' => '2026-10-17 11:50:00',
            ],
            [
                'seller_email' => 'darlyngarcia71@gmail.com',
                'device_type_id' => $smartphoneTypeId,
                'secondary_type_ids' => [$smartphoneTypeId, $tabletTypeId],
                'device_details' => 'Bulk Lot: 6x Mixed Tablets & Smartphones',
                'lot_item_count' => 6,
                'condition' => 'minor_damage',
                'description' => 'Assorted lot containing 3 Android smartphones and 3 8-inch Android tablets. 4 devices boot to setup screen with touch latency; 2 units have broken digitizers. Great bargain for electronics recyclers.',
                'estimated_weight' => 1.95,
                'carbon_footprint' => 4.49,
                'suggested_price' => 1650.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'created_at' => '2026-10-17 15:30:00',
            ],
            [
                'seller_email' => 'marklhemuel50@gmail.com',
                'device_type_id' => $tabletTypeId,
                'secondary_type_ids' => [$tabletTypeId],
                'device_details' => 'Bulk Lot: 4x Apple iPad Tablets for Scrap & Refurbishing',
                'lot_item_count' => 4,
                'condition' => 'minor_damage',
                'description' => '4 older generation Apple iPad units (iPad Air and iPad Mini). Housing scuffs, 2 with cracked front glass, 2 with degraded batteries. Unlocked from iCloud, good for LCD backlight and housing recovery.',
                'estimated_weight' => 1.80,
                'carbon_footprint' => 4.14,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'handover_preference' => 'meetup_only',
                'created_at' => '2026-10-18 10:10:00',
            ],
            [
                'seller_email' => 'jhomaribeltran423@gmail.com',
                'device_type_id' => $smartphoneTypeId,
                'secondary_type_ids' => [$smartphoneTypeId],
                'device_details' => 'Bulk Lot: 12x Broken Touchscreen Phones',
                'lot_item_count' => 12,
                'condition' => 'non_functional',
                'description' => '12 dead smartphones with damaged motherboards, water intrusion, or shattered displays. Sorted and pre-segregated for circuit board recycling, tantalum capacitor salvage, and zero-landfill processing.',
                'estimated_weight' => 2.25,
                'carbon_footprint' => 5.18,
                'suggested_price' => 800.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'created_at' => '2026-10-18 14:45:00',
            ],
        ];

        foreach ($bulkLots as $lot) {
            $seller = DB::table('users')->where('email', $lot['seller_email'])->first();
            $sellerId = $seller ? $seller->id : $fallbackSellerId;
            $sellerName = $seller ? $seller->name : 'Seller';
            $sellerBarangay = $seller && !empty($seller->barangay) ? $seller->barangay : 'San Carlos City';

            // Check if listing with this title already exists
            $existingListing = DB::table('listings')->where('device_details', $lot['device_details'])->first();

            $listingData = [
                'user_id' => $sellerId,
                'listing_type' => 'bulk_lot',
                'lot_item_count' => $lot['lot_item_count'],
                'device_type_id' => $lot['device_type_id'],
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => $lot['device_details'],
                'condition' => $lot['condition'],
                'description' => $lot['description'],
                'estimated_weight' => $lot['estimated_weight'],
                'carbon_footprint' => $lot['carbon_footprint'],
                'suggested_price' => $lot['suggested_price'],
                'intended_action' => $lot['intended_action'],
                'handover_preference' => $lot['handover_preference'],
                'pickup_address' => 'Brgy. ' . $sellerBarangay . ', San Carlos City, Pangasinan 2420',
                'status' => 'available',
                'created_at' => $lot['created_at'],
                'updated_at' => $lot['created_at'],
            ];

            if ($existingListing) {
                DB::table('listings')->where('id', $existingListing->id)->update($listingData);
                $listingId = $existingListing->id;
            } else {
                $listingId = DB::table('listings')->insertGetId($listingData);
            }

            // Sync into listing_device_types if table exists
            if (Schema::hasTable('listing_device_types')) {
                foreach ($lot['secondary_type_ids'] as $tid) {
                    $exists = DB::table('listing_device_types')
                        ->where('listing_id', $listingId)
                        ->where('device_type_id', $tid)
                        ->exists();

                    if (!$exists) {
                        DB::table('listing_device_types')->insert([
                            'listing_id' => $listingId,
                            'device_type_id' => $tid,
                            'created_at' => $lot['created_at'],
                            'updated_at' => $lot['created_at'],
                        ]);
                    }
                }
            }

            // Insert into audit_logs table
            if (Schema::hasTable('audit_logs')) {
                $auditExists = DB::table('audit_logs')
                    ->where('model_type', 'Listing')
                    ->where('model_id', $listingId)
                    ->where('action', 'listing_created')
                    ->exists();

                $auditDesc = "User {$sellerName} posted new e-waste bulk lot: {$lot['device_details']} ({$lot['lot_item_count']} pcs) for {$lot['intended_action']}";

                if ($auditExists) {
                    DB::table('audit_logs')
                        ->where('model_type', 'Listing')
                        ->where('model_id', $listingId)
                        ->where('action', 'listing_created')
                        ->update([
                            'user_id' => $sellerId,
                            'description' => $auditDesc,
                            'created_at' => $lot['created_at'],
                            'updated_at' => $lot['created_at'],
                        ]);
                } else {
                    DB::table('audit_logs')->insert([
                        'user_id' => $sellerId,
                        'action' => 'listing_created',
                        'model_type' => 'Listing',
                        'model_id' => $listingId,
                        'description' => $auditDesc,
                        'ip_address' => '127.0.0.1',
                        'user_agent' => 'E-Benta Seeder/1.0',
                        'created_at' => $lot['created_at'],
                        'updated_at' => $lot['created_at'],
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('listings')) {
            return;
        }

        $bulkTitles = [
            'Bulk Lot: 10x Assorted Android Phones',
            'Bulk Lot: 5x Defective School Tablets',
            'Bulk Lot: 8x Old Smartphones',
            'Bulk Lot: 15x Depleted & Broken Smartphones Scrap Bundle',
            'Bulk Lot: 6x Mixed Tablets & Smartphones',
            'Bulk Lot: 4x Apple iPad Tablets for Scrap & Refurbishing',
            'Bulk Lot: 12x Broken Touchscreen Phones',
        ];

        $listingIds = DB::table('listings')->whereIn('device_details', $bulkTitles)->pluck('id');

        if (Schema::hasTable('listing_device_types')) {
            DB::table('listing_device_types')->whereIn('listing_id', $listingIds)->delete();
        }

        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')->where('model_type', 'Listing')->whereIn('model_id', $listingIds)->delete();
        }

        DB::table('listings')->whereIn('id', $listingIds)->delete();
    }
};
