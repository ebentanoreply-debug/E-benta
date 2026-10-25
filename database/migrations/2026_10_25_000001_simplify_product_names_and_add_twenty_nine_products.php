<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 1. Simplifies product names.
     * 2. Spreads the 5 test seller transactions & offers across different dates (Oct 14, 15, 16, 17, 18).
     * 3. Adds 29 products without images spread across different dates (Oct 14, 15, 16, 17, 18).
     * 4. Updates all audit logs, notifications, and messages to match the varied dates.
     * 5. Excludes photo/image edits from audit logs.
     */
    public function up(): void
    {
        if (!Schema::hasTable('listings') || !Schema::hasTable('users')) {
            return;
        }

        // 1. Simplify verbose/complex product names for existing listings
        $simplifications = [
            'Intel Core i7 10th Gen, 16GB RAM, 512GB SSD, 14" FHD IPS display' => 'Lenovo ThinkPad X1',
            'Apple MacBook Pro 13-inch (Intel Core i5, 8GB RAM, 256GB SSD, Retina Display)' => 'MacBook Pro 13"',
            'Dell OptiPlex Small Form Factor PC (Intel Core i5-8500, 8GB DDR4, 500GB HDD, 200W PSU)' => 'Dell OptiPlex PC',
            'Samsung Galaxy S21 5G, 128GB Storage, Phantom Gray, Exynos 2100' => 'Samsung Galaxy S21',
            'HP LaserJet Pro Monochrome Laser Printer (Duplex Printing, USB/Ethernet)' => 'HP LaserJet Pro',
            'LG 34-inch UltraWide IPS LED Monitor (2560x1080, HDMI x 2, DisplayPort)' => 'LG UltraWide 34"',
            'ASUS VivoBook 15 (AMD Ryzen 5, 8GB DDR4, 1TB HDD, 15.6" NanoEdge)' => 'ASUS VivoBook 15',
            'Apple iPhone 12, 64GB, Black, Factory Unlocked' => 'Apple iPhone 12',
            'Dell UltraSharp U2720Q 27-inch 4K UHD IPS Monitor' => 'Dell UltraSharp 27"',
            'HP Pavilion Tower PC (AMD Ryzen 3, 8GB RAM, 128GB SSD + 1TB HDD)' => 'HP Pavilion Desktop',
            'Apple iPad Air (3rd Gen), 64GB Wi-Fi, Space Gray, 10.5" Retina' => 'Apple iPad Air',
            'Dell XPS 13 9360 (Intel Core i5-7200U, 8GB LPDDR3, 256GB NVMe SSD, InfinityEdge Display)' => 'Dell XPS 13',
            'Apple iPhone 13, 128GB, Midnight Blue, Super Retina XDR OLED' => 'Apple iPhone 13',
            'Samsung Galaxy Tab S7, 128GB, Mystic Black, 11-inch 120Hz Display with S-Pen' => 'Samsung Galaxy Tab S7',
            'Apple MacBook Air 13" M1 (2020), 8GB Unified RAM, 256GB SSD, Space Gray' => 'MacBook Air M1',
            'Dell OptiPlex 7070 Micro PC (Intel Core i5-9500T, 16GB DDR4, 256GB NVMe SSD, Original 65W Power Brick)' => 'Dell OptiPlex Micro',
            'Samsung Galaxy S22 5G (Phantom Black, 128GB Storage, 8GB RAM, Dynamic AMOLED 2X)' => 'Samsung Galaxy S22',
            'Apple iPad Pro 12.9" 3rd Gen (64GB Wi-Fi, Space Gray, A12X Bionic, ProMotion 120Hz)' => 'iPad Pro 12.9"',
            'LG UltraWide 34-inch Curved IPS LED Monitor (3440x1440 UWQHD, HDMI x 2, DisplayPort)' => 'LG Curved Monitor 34"',
        ];

        foreach ($simplifications as $verbose => $simple) {
            DB::table('listings')->where('device_details', $verbose)->update(['device_details' => $simple]);

            if (Schema::hasTable('audit_logs')) {
                $logs = DB::table('audit_logs')
                    ->where('model_type', 'Listing')
                    ->where('description', 'like', "%{$verbose}%")
                    ->get();

                foreach ($logs as $log) {
                    $newDesc = str_replace($verbose, $simple, $log->description);
                    DB::table('audit_logs')->where('id', $log->id)->update(['description' => $newDesc]);
                }
            }
        }

        // 2. SPREAD OFFERS & TRANSACTIONS ACROSS DIFFERENT DATES (Oct 14, 15, 16, 17, 18)
        $offerSchedules = [
            'jimmybeltran@gmail.com' => [
                'day' => '2026-10-14',
                'listing_time' => '2026-10-14 08:44:00',
                'offer_time' => '2026-10-14 10:44:00',
                'accepted_time' => '2026-10-14 11:14:00',
                'pickup_time' => '2026-10-14 16:30:00',
                'completed_time' => '2026-10-14 16:45:00',
            ],
            'lomibaojerwin@gmail.com' => [
                'day' => '2026-10-15',
                'listing_time' => '2026-10-15 09:15:00',
                'offer_time' => '2026-10-15 11:25:00',
                'accepted_time' => '2026-10-15 12:10:00',
                'pickup_time' => '2026-10-15 16:45:00',
                'completed_time' => '2026-10-15 17:00:00',
            ],
            'benignogarcia23@gmail.com' => [
                'day' => '2026-10-16',
                'listing_time' => '2026-10-16 09:30:00',
                'offer_time' => '2026-10-16 13:40:00',
                'accepted_time' => '2026-10-16 14:20:00',
                'pickup_time' => '2026-10-16 17:15:00',
                'completed_time' => '2026-10-16 17:30:00',
            ],
            'krisaquino' => [
                'day' => '2026-10-17',
                'listing_time' => '2026-10-17 10:00:00',
                'offer_time' => '2026-10-17 14:15:00',
                'accepted_time' => '2026-10-17 14:55:00',
                'pickup_time' => '2026-10-17 17:45:00',
                'completed_time' => null,
            ],
            'Abeaustria@gmail.com' => [
                'day' => '2026-10-18',
                'listing_time' => '2026-10-18 10:30:00',
                'offer_time' => '2026-10-18 15:50:00',
                'accepted_time' => '2026-10-18 16:30:00',
                'pickup_time' => '2026-10-18 18:20:00',
                'completed_time' => null,
            ],
        ];

        foreach ($offerSchedules as $emailKey => $sched) {
            $buyer = DB::table('users')->where('email', 'like', "%{$emailKey}%")->first();
            if (!$buyer) {
                continue;
            }

            $offer = DB::table('offers')->where('buyer_id', $buyer->id)->first();
            if (!$offer) {
                continue;
            }

            // Update Offer timestamps
            DB::table('offers')->where('id', $offer->id)->update([
                'created_at' => $sched['offer_time'],
                'responded_at' => $sched['accepted_time'],
                'cash_received_at' => $sched['completed_time'] ? $sched['pickup_time'] : null,
                'proposed_pickup_date' => $sched['pickup_time'],
                'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
            ]);

            // Update Listing timestamps
            DB::table('listings')->where('id', $offer->listing_id)->update([
                'created_at' => $sched['listing_time'],
                'matched_at' => $sched['accepted_time'],
                'pickup_scheduled_at' => $sched['pickup_time'],
                'picked_up_at' => $sched['completed_time'] ? $sched['pickup_time'] : null,
                'delivered_at' => $sched['completed_time'] ? $sched['pickup_time'] : null,
                'processed_at' => $sched['completed_time'] ? Carbon::parse($sched['pickup_time'])->addHours(2)->toDateTimeString() : null,
                'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
            ]);

            if (Schema::hasTable('listing_photos')) {
                DB::table('listing_photos')->where('listing_id', $offer->listing_id)->update([
                    'created_at' => $sched['listing_time'],
                    'updated_at' => $sched['listing_time'],
                ]);
            }

            // Update Audit Logs for this offer
            if (Schema::hasTable('audit_logs')) {
                // 1. offer_created
                DB::table('audit_logs')
                    ->where('model_type', 'Offer')
                    ->where('model_id', $offer->id)
                    ->where('action', 'offer_created')
                    ->update([
                        'created_at' => $sched['offer_time'],
                        'updated_at' => $sched['offer_time'],
                    ]);

                // 2. offer_accepted
                DB::table('audit_logs')
                    ->where('model_type', 'Offer')
                    ->where('model_id', $offer->id)
                    ->where('action', 'offer_accepted')
                    ->update([
                        'created_at' => $sched['accepted_time'],
                        'updated_at' => $sched['accepted_time'],
                    ]);

                // 3. item_picked_up (Listing)
                if ($sched['completed_time']) {
                    DB::table('audit_logs')
                        ->where('model_type', 'Listing')
                        ->where('model_id', $offer->listing_id)
                        ->where('action', 'item_picked_up')
                        ->update([
                            'created_at' => $sched['pickup_time'],
                            'updated_at' => $sched['pickup_time'],
                        ]);

                    // 4. transaction_completed
                    DB::table('audit_logs')
                        ->where('model_type', 'Offer')
                        ->where('model_id', $offer->id)
                        ->where('action', 'transaction_completed')
                        ->update([
                            'created_at' => $sched['completed_time'],
                            'updated_at' => $sched['completed_time'],
                        ]);
                }

                // 5. listing_created
                DB::table('audit_logs')
                    ->where('model_type', 'Listing')
                    ->where('model_id', $offer->listing_id)
                    ->where('action', 'listing_created')
                    ->update([
                        'created_at' => $sched['listing_time'],
                        'updated_at' => $sched['listing_time'],
                    ]);
            }

            // Update messages
            if (Schema::hasTable('messages')) {
                $messages = DB::table('messages')->where('offer_id', $offer->id)->orderBy('id')->get();
                $msgBase = Carbon::parse($sched['offer_time']);
                foreach ($messages as $mIdx => $msg) {
                    $mTime = (clone $msgBase)->addMinutes(($mIdx + 1) * 8)->toDateTimeString();
                    DB::table('messages')->where('id', $msg->id)->update([
                        'created_at' => $mTime,
                        'updated_at' => $mTime,
                        'read_at' => Carbon::parse($mTime)->addMinute()->toDateTimeString(),
                    ]);
                }
            }

            // Update notifications
            if (Schema::hasTable('notifications')) {
                DB::table('notifications')
                    ->where('type', 'offer_received')
                    ->where(function ($q) use ($offer) {
                        $q->where('data->offer_id', $offer->id)
                          ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                          ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                    })
                    ->update([
                        'created_at' => $sched['offer_time'],
                        'updated_at' => $sched['offer_time'],
                    ]);

                DB::table('notifications')
                    ->where('type', 'offer_accepted')
                    ->where(function ($q) use ($offer) {
                        $q->where('data->offer_id', $offer->id)
                          ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                          ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                    })
                    ->update([
                        'created_at' => $sched['accepted_time'],
                        'updated_at' => $sched['accepted_time'],
                    ]);

                if ($sched['completed_time']) {
                    DB::table('notifications')
                        ->where('type', 'transaction_completed')
                        ->where(function ($q) use ($offer) {
                            $q->where('data->offer_id', $offer->id)
                              ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                              ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                        })
                        ->update([
                            'created_at' => $sched['pickup_time'],
                            'updated_at' => $sched['pickup_time'],
                        ]);
                }
            }

            // Update impact logs, commissions, payments
            if (Schema::hasTable('impact_logs')) {
                DB::table('impact_logs')->where('offer_id', $offer->id)->update([
                    'created_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                    'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                ]);
            }
            if (Schema::hasTable('commissions')) {
                DB::table('commissions')->where('offer_id', $offer->id)->update([
                    'created_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                    'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                ]);
            }
            if (Schema::hasTable('payments')) {
                DB::table('payments')->where('offer_id', $offer->id)->update([
                    'created_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                    'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
                ]);
            }
        }

        // 3. DEFINITION OF 29 NEW PRODUCTS WITHOUT IMAGES (DISTRIBUTED ACROSS OCT 14 - OCT 18)
        $newProducts = [
            // --- October 14, 2026 ---
            1 => [
                'seller_email' => 'munozantonette5@gmail.com',
                'type_name' => 'Laptop',
                'brand_name' => 'Acer',
                'model_name' => 'Acer Aspire 5',
                'device_details' => 'Acer Aspire 5',
                'condition' => 'working',
                'description' => 'Working Acer Aspire 5 with Intel Core i3, 8GB RAM, and 256GB SSD. Minor wear on palm rest. Includes original charger.',
                'estimated_weight' => 1.80,
                'carbon_footprint' => 4.14,
                'suggested_price' => 3500.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 09:30:00',
            ],
            2 => [
                'seller_email' => 'dg3946922@gmail.com',
                'type_name' => 'Printer',
                'brand_name' => 'Canon',
                'model_name' => 'Canon PIXMA',
                'device_details' => 'Canon PIXMA G3010',
                'condition' => 'minor_damage',
                'description' => 'Eco-tank all-in-one printer. Scanner and feeder fully operational; printhead needs minor flushing.',
                'estimated_weight' => 5.20,
                'carbon_footprint' => 11.96,
                'suggested_price' => 1200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 11:15:00',
            ],
            3 => [
                'seller_email' => 'jhomaribeltran423@gmail.com',
                'type_name' => 'Mouse',
                'brand_name' => 'Logitech',
                'model_name' => 'Logitech MX Master 3',
                'device_details' => 'Logitech MX Master 3',
                'condition' => 'working',
                'description' => 'Ergonomic wireless productivity mouse. Electromagnetic scroll wheel and battery tested 100% working.',
                'estimated_weight' => 0.14,
                'carbon_footprint' => 0.32,
                'suggested_price' => 1500.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 13:45:00',
            ],
            4 => [
                'seller_email' => 'jensenvincejavier@gmail.com',
                'type_name' => 'Router',
                'brand_name' => 'TP-Link',
                'model_name' => 'TP-Link WiFi 6 Router',
                'device_details' => 'TP-Link Archer AX50',
                'condition' => 'working',
                'description' => 'Dual-band Gigabit Wi-Fi 6 wireless router with 4 high-gain antennas. Reset to factory default.',
                'estimated_weight' => 0.55,
                'carbon_footprint' => 1.27,
                'suggested_price' => 1400.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 15:20:00',
            ],
            5 => [
                'seller_email' => 'markrejierosario12@gmail.com',
                'type_name' => 'Desktop Computer',
                'brand_name' => 'Sony',
                'model_name' => null,
                'device_details' => 'Sony PlayStation 4 Slim',
                'condition' => 'working',
                'description' => 'Clean 500GB PS4 console. Tested HDMI output, optical drive, and Wi-Fi connection. Includes power cord.',
                'estimated_weight' => 2.10,
                'carbon_footprint' => 4.83,
                'suggested_price' => 4500.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 16:50:00',
            ],
            6 => [
                'seller_email' => 'marklhemuel50@gmail.com',
                'type_name' => 'Keyboard',
                'brand_name' => 'Apple',
                'model_name' => 'Apple Magic Keyboard',
                'device_details' => 'Apple Magic Keyboard',
                'condition' => 'working',
                'description' => 'Slim wireless Bluetooth keyboard with rechargeable battery. Scissor mechanism keys fully responsive.',
                'estimated_weight' => 0.24,
                'carbon_footprint' => 0.55,
                'suggested_price' => 1800.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-14 18:10:00',
            ],

            // --- October 15, 2026 ---
            7 => [
                'seller_email' => 'vincentagbuya67@gmail.com',
                'type_name' => 'Laptop',
                'brand_name' => 'Dell',
                'model_name' => 'Dell XPS 13',
                'device_details' => 'Dell Inspiron 15',
                'condition' => 'minor_damage',
                'description' => 'Core i5 8th Gen laptop with 15.6" anti-glare screen. Weak battery (requires AC adapter plugged in).',
                'estimated_weight' => 2.00,
                'carbon_footprint' => 4.60,
                'suggested_price' => 2800.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-15 08:45:00',
            ],
            8 => [
                'seller_email' => 'christianbautista@gmail.com',
                'type_name' => 'Tablet',
                'brand_name' => 'Samsung',
                'model_name' => 'Samsung Galaxy Tab S7',
                'device_details' => 'Samsung Galaxy Tab A8',
                'condition' => 'working',
                'description' => '10.5-inch entertainment tablet with quad speakers and Dolby Atmos. Good battery health, clean firmware.',
                'estimated_weight' => 0.51,
                'carbon_footprint' => 1.17,
                'suggested_price' => 2500.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-15 10:20:00',
            ],
            9 => [
                'seller_email' => 'marygracedelacruz@gmail.com',
                'type_name' => 'Printer',
                'brand_name' => 'HP',
                'model_name' => 'HP LaserJet Pro',
                'device_details' => 'HP DeskJet 2330',
                'condition' => 'non_functional',
                'description' => 'Ink cartridge carriage motor jammed. Clean casing, power module, and electronic board for parts harvest.',
                'estimated_weight' => 3.42,
                'carbon_footprint' => 7.87,
                'suggested_price' => 450.00,
                'intended_action' => 'recycle',
                'exact_date' => '2026-10-15 12:35:00',
            ],
            10 => [
                'seller_email' => 'kyleramos17@gmail.com',
                'type_name' => 'Router',
                'brand_name' => 'Netgear',
                'model_name' => 'Netgear Nighthawk',
                'device_details' => 'Netgear Nighthawk AC1900',
                'condition' => 'working',
                'description' => 'High performance smart Wi-Fi router. 1GHz dual-core processor, USB 3.0 port for external media sharing.',
                'estimated_weight' => 0.75,
                'carbon_footprint' => 1.73,
                'suggested_price' => 1100.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-15 14:15:00',
            ],
            11 => [
                'seller_email' => 'miashielagraceuson@gmail.com',
                'type_name' => 'Monitor',
                'brand_name' => 'ASUS',
                'model_name' => 'ASUS ProArt 32"',
                'device_details' => 'ASUS ProArt Display',
                'condition' => 'minor_damage',
                'description' => 'Color-accurate creator monitor with slight stand swivel looseness. Screen panel 100% scratch-free.',
                'estimated_weight' => 6.20,
                'carbon_footprint' => 14.26,
                'suggested_price' => 3200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-15 16:00:00',
            ],
            12 => [
                'seller_email' => 'darlyngarcia711@gmail.com',
                'type_name' => 'Keyboard',
                'brand_name' => 'ASUS',
                'model_name' => 'Mechanical RGB Keyboard',
                'device_details' => 'Mechanical Gaming Keyboard',
                'condition' => 'working',
                'description' => 'Tactile blue switch mechanical keyboard with per-key RGB backlighting and braided detachable USB cable.',
                'estimated_weight' => 0.95,
                'carbon_footprint' => 2.19,
                'suggested_price' => 900.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-15 17:30:00',
            ],

            // --- October 16, 2026 ---
            13 => [
                'seller_email' => 'daisygeegarcia21@gmail.com',
                'type_name' => 'Mouse',
                'brand_name' => 'Apple',
                'model_name' => 'Apple Magic Mouse',
                'device_details' => 'Apple Magic Mouse 2',
                'condition' => 'working',
                'description' => 'Multi-Touch surface mouse with built-in rechargeable lithium-ion battery. Seamless gesture navigation.',
                'estimated_weight' => 0.10,
                'carbon_footprint' => 0.23,
                'suggested_price' => 1200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 09:10:00',
            ],
            14 => [
                'seller_email' => 'markyvangarcia@gmail.com',
                'type_name' => 'Laptop',
                'brand_name' => 'Lenovo',
                'model_name' => 'Lenovo ThinkPad X1',
                'device_details' => 'Lenovo IdeaPad 3',
                'condition' => 'working',
                'description' => 'Everyday computing laptop with AMD Ryzen 3, 8GB DDR4 RAM, and 512GB NVMe SSD. Clean webcam with privacy shutter.',
                'estimated_weight' => 1.70,
                'carbon_footprint' => 3.91,
                'suggested_price' => 3800.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 10:45:00',
            ],
            15 => [
                'seller_email' => 'seller@test.com',
                'type_name' => 'Desktop Computer',
                'brand_name' => 'Apple',
                'model_name' => 'iMac 27"',
                'device_details' => 'iMac 27" Core i5',
                'condition' => 'minor_damage',
                'description' => 'All-in-one desktop with 5K Retina display. Internal HDD replaced with fast 500GB SSD. Minor glass chip at corner.',
                'estimated_weight' => 8.90,
                'carbon_footprint' => 20.47,
                'suggested_price' => 6500.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 12:15:00',
            ],
            16 => [
                'seller_email' => 'carriojoseph2489@gmail.com',
                'type_name' => 'Smartphone',
                'brand_name' => 'Samsung',
                'model_name' => 'Samsung Galaxy S21',
                'device_details' => 'Samsung Galaxy S20 FE',
                'condition' => 'working',
                'description' => 'Tested 120Hz Super AMOLED display, 128GB internal storage, triple rear camera setup. Openline to all SIMs.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 3200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 14:00:00',
            ],
            17 => [
                'seller_email' => 'jimboymalican12@gmail.com',
                'type_name' => 'Printer',
                'brand_name' => 'Canon',
                'model_name' => 'Canon PIXMA',
                'device_details' => 'Canon imageCLASS LBP6030w',
                'condition' => 'working',
                'description' => 'Compact monochrome laser printer with built-in Wi-Fi. Fast 18 ppm output, sharp black text reproduction.',
                'estimated_weight' => 5.00,
                'carbon_footprint' => 11.50,
                'suggested_price' => 1800.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 15:40:00',
            ],
            18 => [
                'seller_email' => 'rhonamaebulatao@gmail.com',
                'type_name' => 'Monitor',
                'brand_name' => 'Dell',
                'model_name' => 'Dell U2720Q 27"',
                'device_details' => 'Dell SE2422H 24" Monitor',
                'condition' => 'working',
                'description' => '24-inch Full HD 75Hz monitor with AMD FreeSync. Slim bezels, HDMI and VGA input ports. Includes power cord.',
                'estimated_weight' => 3.80,
                'carbon_footprint' => 8.74,
                'suggested_price' => 2100.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-16 17:15:00',
            ],

            // --- October 17, 2026 ---
            19 => [
                'seller_email' => 'Abeaustria@gmail.com',
                'type_name' => 'Laptop',
                'brand_name' => 'HP',
                'model_name' => 'HP Pavilion 15',
                'device_details' => 'HP Pavilion 15 Gaming',
                'condition' => 'minor_damage',
                'description' => 'Core i5 gaming laptop with GTX 1050 graphics. Minor keycap wear on W-A-S-D keys; cooling and motherboard excellent.',
                'estimated_weight' => 2.20,
                'carbon_footprint' => 5.06,
                'suggested_price' => 4200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 08:30:00',
            ],
            20 => [
                'seller_email' => 'munozantonette5@gmail.com',
                'type_name' => 'Tablet',
                'brand_name' => 'Apple',
                'model_name' => 'iPad Air',
                'device_details' => 'Apple iPad Mini 5',
                'condition' => 'working',
                'description' => '7.9-inch Retina display with True Tone. A12 Bionic chip, 64GB storage, supports Apple Pencil 1st Gen.',
                'estimated_weight' => 0.30,
                'carbon_footprint' => 0.69,
                'suggested_price' => 3600.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 10:15:00',
            ],
            21 => [
                'seller_email' => 'dg3946922@gmail.com',
                'type_name' => 'Mouse',
                'brand_name' => 'Logitech',
                'model_name' => 'Logitech MX Master 3',
                'device_details' => 'Logitech G502 Hero',
                'condition' => 'working',
                'description' => 'High performance gaming mouse with 25K DPI sensor, 11 programmable buttons, and adjustable weight tuning.',
                'estimated_weight' => 0.12,
                'carbon_footprint' => 0.28,
                'suggested_price' => 850.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 11:50:00',
            ],
            22 => [
                'seller_email' => 'jhomaribeltran423@gmail.com',
                'type_name' => 'Router',
                'brand_name' => 'TP-Link',
                'model_name' => 'TP-Link WiFi 6 Router',
                'device_details' => 'TP-Link Deco Mesh WiFi',
                'condition' => 'working',
                'description' => 'Whole home mesh Wi-Fi system unit. Seamless roaming coverage up to 2,000 sq ft. Tested and updated to latest firmware.',
                'estimated_weight' => 0.60,
                'carbon_footprint' => 1.38,
                'suggested_price' => 1600.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 13:30:00',
            ],
            23 => [
                'seller_email' => 'jensenvincejavier@gmail.com',
                'type_name' => 'Monitor',
                'brand_name' => 'Sony',
                'model_name' => null,
                'device_details' => 'Sony Bravia LED Display 32"',
                'condition' => 'minor_damage',
                'description' => '32-inch commercial display panel for CCTV or secondary monitor setup. Missing remote, buttons on panel fully functional.',
                'estimated_weight' => 5.50,
                'carbon_footprint' => 12.65,
                'suggested_price' => 2400.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 15:10:00',
            ],
            24 => [
                'seller_email' => 'markrejierosario12@gmail.com',
                'type_name' => 'Desktop Computer',
                'brand_name' => 'Dell',
                'model_name' => 'Dell OptiPlex',
                'device_details' => 'Dell OptiPlex 3050 Tower',
                'condition' => 'working',
                'description' => 'Core i5 7th Gen business desktop tower, 8GB DDR4 RAM, 1TB HDD. Clean power supply unit and working DVD-RW drive.',
                'estimated_weight' => 7.20,
                'carbon_footprint' => 16.56,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-17 16:45:00',
            ],

            // --- October 18, 2026 ---
            25 => [
                'seller_email' => 'marklhemuel50@gmail.com',
                'type_name' => 'Smartphone',
                'brand_name' => 'Samsung',
                'model_name' => 'Samsung Galaxy S21',
                'device_details' => 'Samsung Galaxy A52',
                'condition' => 'minor_damage',
                'description' => '6.5" Super AMOLED 90Hz phone. Minor glass back scuffs. Quad 64MP OIS camera, speakers, and fast charging tested.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 2100.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-18 09:15:00',
            ],
            26 => [
                'seller_email' => 'vincentagbuya67@gmail.com',
                'type_name' => 'Cable / Wire',
                'brand_name' => 'Dell',
                'model_name' => null,
                'device_details' => 'Copper Cable & Power Cord Bundle',
                'condition' => 'non_functional',
                'description' => 'Heavy lot of assorted copper power cords, VGA/DVI cables, and electrical wiring suited for e-waste scrap recycling.',
                'estimated_weight' => 4.50,
                'carbon_footprint' => 10.35,
                'suggested_price' => 350.00,
                'intended_action' => 'recycle',
                'exact_date' => '2026-10-18 10:40:00',
            ],
            27 => [
                'seller_email' => 'christianbautista@gmail.com',
                'type_name' => 'Printer',
                'brand_name' => 'HP',
                'model_name' => 'HP LaserJet Pro',
                'device_details' => 'HP LaserJet 1020 Plus',
                'condition' => 'non_functional',
                'description' => 'Classic laser printer with bad fuser assembly. Power supply board and copper coils intact for component salvaging.',
                'estimated_weight' => 5.70,
                'carbon_footprint' => 13.11,
                'suggested_price' => 600.00,
                'intended_action' => 'recycle',
                'exact_date' => '2026-10-18 12:20:00',
            ],
            28 => [
                'seller_email' => 'marygracedelacruz@gmail.com',
                'type_name' => 'Smartphone',
                'brand_name' => 'Apple',
                'model_name' => 'iPhone 12',
                'device_details' => 'Apple iPhone 11 64GB',
                'condition' => 'minor_damage',
                'description' => 'Liquid Retina HD display with hairline crack in bottom corner. TrueDepth camera and Face ID working, battery health 79%.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 3900.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-18 14:10:00',
            ],
            29 => [
                'seller_email' => 'seller@test.com',
                'type_name' => 'Desktop Computer',
                'brand_name' => 'Lenovo',
                'model_name' => 'Lenovo ThinkPad X1',
                'device_details' => 'Lenovo ThinkCentre Tiny PC',
                'condition' => 'working',
                'description' => 'Ultra compact mini workstation PC with Core i5, 16GB DDR4, and 256GB NVMe SSD. Perfect for micro server or POS.',
                'estimated_weight' => 1.30,
                'carbon_footprint' => 2.99,
                'suggested_price' => 2600.00,
                'intended_action' => 'sell',
                'exact_date' => '2026-10-18 16:00:00',
            ],
        ];

        // Cache device lookup tables
        $deviceTypes = DB::table('device_types')->pluck('id', 'name');
        $deviceBrands = DB::table('device_brands')->pluck('id', 'name');
        $deviceModels = DB::table('device_models')->pluck('id', 'model_name');

        foreach ($newProducts as $p) {
            $seller = DB::table('users')->where('email', $p['seller_email'])->first()
                ?? DB::table('users')->where('role', 'seller')->first();

            if (!$seller) {
                continue;
            }

            $typeId = $deviceTypes[$p['type_name']] ?? (DB::table('device_types')->first()->id ?? 1);
            $brandId = $deviceBrands[$p['brand_name']] ?? (DB::table('device_brands')->first()->id ?? 1);
            $modelId = !empty($p['model_name']) && isset($deviceModels[$p['model_name']])
                ? $deviceModels[$p['model_name']]
                : null;

            $createdStr = $p['exact_date'];
            $pickupAddress = 'Brgy. ' . ($seller->barangay ?? 'San Carlos City') . ', San Carlos City, Pangasinan 2420';

            $existing = DB::table('listings')
                ->where('user_id', $seller->id)
                ->where('device_details', $p['device_details'])
                ->first();

            if (!$existing) {
                $listingId = DB::table('listings')->insertGetId([
                    'user_id' => $seller->id,
                    'device_type_id' => $typeId,
                    'device_brand_id' => $brandId,
                    'device_model_id' => $modelId,
                    'device_details' => $p['device_details'],
                    'condition' => $p['condition'],
                    'description' => $p['description'],
                    'estimated_weight' => $p['estimated_weight'],
                    'carbon_footprint' => $p['carbon_footprint'],
                    'suggested_price' => $p['suggested_price'],
                    'intended_action' => $p['intended_action'],
                    'handover_preference' => 'pickup',
                    'pickup_address' => $pickupAddress,
                    'status' => 'available',
                    'created_at' => $createdStr,
                    'updated_at' => $createdStr,
                ]);
            } else {
                $listingId = $existing->id;
                DB::table('listings')->where('id', $listingId)->update([
                    'device_details' => $p['device_details'],
                    'created_at' => $createdStr,
                    'updated_at' => $createdStr,
                ]);
            }

            // Ensure NO photos exist for these 29 products so user can edit and add images manually
            if (Schema::hasTable('listing_photos')) {
                DB::table('listing_photos')->where('listing_id', $listingId)->delete();
            }

            // Insert audit log with the exact varied date
            if (Schema::hasTable('audit_logs')) {
                DB::table('audit_logs')->updateOrInsert(
                    [
                        'user_id' => $seller->id,
                        'action' => 'listing_created',
                        'model_type' => 'Listing',
                        'model_id' => $listingId,
                    ],
                    [
                        'description' => "User {$seller->name} posted new e-waste listing: {$p['device_details']} ({$p['condition']}) for {$p['intended_action']}",
                        'ip_address' => $seller->ip_address ?? '136.158.12.83',
                        'user_agent' => $seller->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0',
                        'created_at' => $createdStr,
                        'updated_at' => $createdStr,
                    ]
                );
            }
        }

        // 4. Exclude any photo/image modification entries from audit logs
        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')
                ->where('model_type', 'ListingPhoto')
                ->orWhere('action', 'like', '%photo%')
                ->delete();
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
