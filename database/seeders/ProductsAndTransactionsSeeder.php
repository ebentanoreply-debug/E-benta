<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\AuditLog;
use App\Models\Commission;
use App\Models\ImpactLog;
use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Message;
use App\Models\Notification;
use App\Models\NotificationData;
use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductsAndTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds realistic electronic listings with customizable image slots,
     * chronological audit logs, realistic transactions under 10, messages, and notifications.
     */
    public function run(): void
    {
        // 0. Ensure Core Test Accounts exist (essential for deploy environments)
        $testSeller = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Test Seller',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'is_verified' => true,
                'id_verification_status' => 'verified',
                'email_verified_at' => '2026-10-14 08:20:00',
                'location_verified_at' => '2026-10-14 08:35:00',
                'address_line_1' => null,
                'barangay' => 'Mabini',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
                'phone' => '09171234567',
                'created_at' => '2026-10-14 08:14:00',
                'updated_at' => '2026-10-14 08:45:00',
            ]
        );

        // Ensure verified status, role, and password
        DB::table('users')->where('id', $testSeller->id)->update([
            'role' => 'seller',
            'is_verified' => 1,
            'id_verification_status' => 'verified',
            'barangay' => 'Mabini',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
            'created_at' => '2026-10-14 08:14:00',
        ]);

        Address::firstOrCreate(
            ['user_id' => $testSeller->id, 'label' => 'Business Location'],
            [
                'address_line_1' => 'Brgy. Mabini',
                'city' => 'San Carlos City',
                'state' => 'Pangasinan',
                'postal_code' => '2420',
                'country' => 'Philippines',
                'is_primary' => true,
                'type' => 'both',
            ]
        );

        $testAdmin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_verified' => true,
                'id_verification_status' => 'verified',
                'email_verified_at' => '2026-10-14 08:05:00',
                'location_verified_at' => '2026-10-14 08:15:00',
                'address_line_1' => null,
                'barangay' => 'Palaris',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
                'phone' => '09177654321',
                'created_at' => '2026-10-14 08:00:00',
                'updated_at' => '2026-10-14 08:30:00',
            ]
        );

        // 1. Definition of 19 Products mapped to active sellers
        $productsData = [
            1 => [
                'seller_email' => 'markyvangarcia@gmail.com', // Mark Yvan Garcia (Tarece)
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 7, // Lenovo
                'device_model_id' => 5, // Lenovo ThinkPad X1
                'device_details' => 'Intel Core i7 10th Gen, 16GB RAM, 512GB SSD, 14" FHD IPS display',
                'condition' => 'working',
                'description' => 'Tested working Lenovo ThinkPad X1 Carbon. Battery health at 82%. Light cosmetic scratches on top lid. Keyboard, trackpad, and screen in excellent condition. Comes with original 65W USB-C charger.',
                'estimated_weight' => 1.45,
                'carbon_footprint' => 3.34,
                'suggested_price' => 2000.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_1.jpg',
                'minutes_after_user' => 35,
            ],
            2 => [
                'seller_email' => 'miashielagraceuson@gmail.com', // Mia Shiela Grace Uson (Coliling)
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 1, // Apple
                'device_model_id' => 1, // MacBook Pro 13"
                'device_details' => 'Apple MacBook Pro 13-inch (Intel Core i5, 8GB RAM, 256GB SSD, Retina Display)',
                'condition' => 'minor_damage',
                'description' => 'MacBook Pro 13" for repair or parts recovery. Screen turns on with faint vertical line on the right edge. Logic board and ports tested working. Good for display replacement or component harvesting.',
                'estimated_weight' => 1.58,
                'carbon_footprint' => 3.63,
                'suggested_price' => 3800.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_2.jpg',
                'minutes_after_user' => 42,
            ],
            3 => [
                'seller_email' => 'darlyngarcia711@gmail.com', // Darlyn Garcia (Turac)
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 3, // Dell
                'device_model_id' => 8, // Dell OptiPlex
                'device_details' => 'Dell OptiPlex Small Form Factor PC (Intel Core i5-8500, 8GB DDR4, 500GB HDD, 200W PSU)',
                'condition' => 'working',
                'description' => 'Decommissioned office desktop unit from San Carlos City administration. Clean motherboard, working cooling fan, fully bootable to BIOS. Perfect for budget home office or student reuse.',
                'estimated_weight' => 5.26,
                'carbon_footprint' => 12.10,
                'suggested_price' => 1400.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_3.jpg',
                'minutes_after_user' => 50,
            ],
            4 => [
                'seller_email' => 'daisygeegarcia21@gmail.com', // Daisy Gee Garcia (Agdao)
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 2, // Samsung
                'device_model_id' => 12, // Samsung Galaxy S21
                'device_details' => 'Samsung Galaxy S21 5G, 128GB Storage, Phantom Gray, Exynos 2100',
                'condition' => 'minor_damage',
                'description' => 'Cracked front glass but AMOLED digitizer and touch function are 100% responsive. Cameras, speakers, wireless charging, and motherboard fully intact. Clean IMEI.',
                'estimated_weight' => 0.17,
                'carbon_footprint' => 0.39,
                'suggested_price' => 2800.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_4.jpg',
                'minutes_after_user' => 25,
            ],
            5 => [
                'seller_email' => 'munozantonette5@gmail.com', // Antonette Muñoz (Bocboc)
                'device_type_id' => 8, // Printer
                'device_brand_id' => 4, // HP
                'device_model_id' => 24, // HP LaserJet Pro
                'device_details' => 'HP LaserJet Pro Monochrome Laser Printer (Duplex Printing, USB/Ethernet)',
                'condition' => 'non_functional',
                'description' => 'Paper jam mechanism error and worn pickup roller. Electronics board, power supply, and stepper motors are intact. Ideal for scrap metal, copper coil harvesting, and spare electronic parts.',
                'estimated_weight' => 7.80,
                'carbon_footprint' => 17.94,
                'suggested_price' => 700.00,
                'intended_action' => 'recycle',
                'image_filename' => 'product_5.jpg',
                'minutes_after_user' => 60,
            ],
            6 => [
                'seller_email' => 'dg3946922@gmail.com', // Daisy Garcia (Mamarlao)
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 10, // LG
                'device_model_id' => 18, // LG UltraWide 34"
                'device_details' => 'LG 34-inch UltraWide IPS LED Monitor (2560x1080, HDMI x 2, DisplayPort)',
                'condition' => 'minor_damage',
                'description' => 'Intermittent backlight on left side, suspected bad LED strip. Display panel has zero cracks or dead pixels. Power adapter and desktop stand included.',
                'estimated_weight' => 6.90,
                'carbon_footprint' => 15.87,
                'suggested_price' => 2300.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_6.jpg',
                'minutes_after_user' => 38,
            ],
            7 => [
                'seller_email' => 'jhomaribeltran423@gmail.com', // Jhomari Beltran (Magtaking)
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 5, // ASUS
                'device_model_id' => 6, // ASUS VivoBook 15
                'device_details' => 'ASUS VivoBook 15 (AMD Ryzen 5, 8GB DDR4, 1TB HDD, 15.6" NanoEdge)',
                'condition' => 'working',
                'description' => 'Good working condition ASUS VivoBook. Minor hinge stiffness. Screen and keyboard functional. Suitable for online schooling or community computer literacy workshops.',
                'estimated_weight' => 1.75,
                'carbon_footprint' => 4.02,
                'suggested_price' => 2500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_7.jpg',
                'minutes_after_user' => 45,
            ],
            8 => [
                'seller_email' => 'jensenvincejavier@gmail.com', // Jensen Vince Javier (Baldog)
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 1, // Apple
                'device_model_id' => 11, // iPhone 12
                'device_details' => 'Apple iPhone 12, 64GB, Black, Factory Unlocked',
                'condition' => 'working',
                'description' => 'Functional iPhone 12 with 81% battery capacity. Minor scratches on back glass, front screen protected with tempered glass. FaceID, Truetone, and cameras 100% working.',
                'estimated_weight' => 0.16,
                'carbon_footprint' => 0.37,
                'suggested_price' => 3500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_8.jpg',
                'minutes_after_user' => 30,
            ],
            9 => [
                'seller_email' => 'markrejierosario12@gmail.com', // Mark Rejie Rosario (Tamayo)
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 3, // Dell
                'device_model_id' => 17, // Dell U2720Q 27"
                'device_details' => 'Dell UltraSharp U2720Q 27-inch 4K UHD IPS Monitor',
                'condition' => 'minor_damage',
                'description' => 'High-end 4K IPS monitor with loose HDMI port 1. HDMI port 2 and DisplayPort work flawlessly with crisp colors. Great for photo editing, CAD, or secondary display setup.',
                'estimated_weight' => 4.40,
                'carbon_footprint' => 10.12,
                'suggested_price' => 1600.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_9.jpg',
                'minutes_after_user' => 40,
            ],
            10 => [
                'seller_email' => 'marklhemuel50@gmail.com', // Mark Lhemuel Ramos (Tandoc)
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 4, // HP
                'device_model_id' => 9, // HP Pavilion Desktop
                'device_details' => 'HP Pavilion Tower PC (AMD Ryzen 3, 8GB RAM, 128GB SSD + 1TB HDD)',
                'condition' => 'working',
                'description' => 'Fully working HP desktop tower. Fresh thermal paste applied. Tested with Windows 10 and diagnostic memory pass. Ideal for home e-waste recovery and reuse.',
                'estimated_weight' => 5.90,
                'carbon_footprint' => 13.57,
                'suggested_price' => 1800.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_10.jpg',
                'minutes_after_user' => 55,
            ],
            11 => [
                'seller_email' => 'vincentagbuya67@gmail.com', // Vincent Agbuya (Ilang)
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 1, // Apple
                'device_model_id' => 15, // iPad Air
                'device_details' => 'Apple iPad Air (3rd Gen), 64GB Wi-Fi, Space Gray, 10.5" Retina',
                'condition' => 'working',
                'description' => 'Tested iPad Air with good battery backup. Clean iCloud and reset to factory settings. TouchID working. Includes magnetic folio cover and charging cable.',
                'estimated_weight' => 0.46,
                'carbon_footprint' => 1.06,
                'suggested_price' => 1700.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_11.jpg',
                'minutes_after_user' => 33,
            ],
            12 => [
                'seller_email' => 'christianbautista@gmail.com', // Christian Bautista (Palaris)
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 3, // Dell
                'device_model_id' => 3, // Dell XPS 13
                'device_details' => 'Dell XPS 13 9360 (Intel Core i5-7200U, 8GB LPDDR3, 256GB NVMe SSD, InfinityEdge Display)',
                'condition' => 'working',
                'description' => 'Compact premium ultrabook. Aluminum chassis with carbon fiber palm rest. Lightweight 1.2kg. Perfect working battery and backlit keyboard.',
                'estimated_weight' => 1.22,
                'carbon_footprint' => 2.81,
                'suggested_price' => 2400.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_12.jpg',
                'minutes_after_user' => 28,
            ],
            13 => [
                'seller_email' => 'marygracedelacruz@gmail.com', // Mary Grace Dela Cruz (Rizal)
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 1, // Apple
                'device_model_id' => 10, // iPhone 13
                'device_details' => 'Apple iPhone 13, 128GB, Midnight Blue, Super Retina XDR OLED',
                'condition' => 'working',
                'description' => 'Original iPhone 13 in pristine condition. Battery health 87%. Zero scratches or dents. Fully unlocked to all Philippine telco networks.',
                'estimated_weight' => 0.17,
                'carbon_footprint' => 0.39,
                'suggested_price' => 4500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_13.jpg',
                'minutes_after_user' => 48,
            ],
            14 => [
                'seller_email' => 'kyleramos17@gmail.com', // Kyle Ramos (Mabini)
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 2, // Samsung
                'device_model_id' => 16, // Galaxy Tab S7
                'device_details' => 'Samsung Galaxy Tab S7, 128GB, Mystic Black, 11-inch 120Hz Display with S-Pen',
                'condition' => 'working',
                'description' => 'Samsung flagship tablet with original magnetic S-Pen included. Snapdragon 865+, quad AKG speakers, expandable MicroSD slot. Flawless working unit.',
                'estimated_weight' => 0.50,
                'carbon_footprint' => 1.15,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_14.jpg',
                'minutes_after_user' => 52,
            ],

            // 5 Products specifically for seller@test.com (Test Seller)
            15 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 1, // Apple
                'device_model_id' => 2, // MacBook Air M1
                'device_details' => 'Apple MacBook Air 13" M1 (2020), 8GB Unified RAM, 256GB SSD, Space Gray',
                'condition' => 'minor_damage',
                'description' => 'Broken left hinge mechanism but Retina display panel and M1 logic board function 100%. Battery health at 88%. Good for student or home workstation.',
                'estimated_weight' => 1.29,
                'carbon_footprint' => 2.97,
                'suggested_price' => 12500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_15.jpg',
                'minutes_after_user' => 30,
            ],
            16 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 2, // Dell
                'device_model_id' => 8, // Dell OptiPlex
                'device_details' => 'Dell OptiPlex 7070 Micro PC (Intel Core i5-9500T, 16GB DDR4, 256GB NVMe SSD, Original 65W Power Brick)',
                'condition' => 'working',
                'description' => 'Compact mini PC decommissioned from office. Clean internals, tested USB and DisplayPort video output. Fully bootable to Windows 11.',
                'estimated_weight' => 1.18,
                'carbon_footprint' => 2.71,
                'suggested_price' => 4200.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_16.jpg',
                'minutes_after_user' => 55,
            ],
            17 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 6, // Samsung
                'device_model_id' => 13, // Samsung Galaxy S22
                'device_details' => 'Samsung Galaxy S22 5G (Phantom Black, 128GB Storage, 8GB RAM, Dynamic AMOLED 2X)',
                'condition' => 'minor_damage',
                'description' => 'Hairline crack on back glass cover. Dynamic AMOLED screen, camera modules, ultrasonic fingerprint scanner, and motherboard are completely flawless.',
                'estimated_weight' => 0.17,
                'carbon_footprint' => 0.39,
                'suggested_price' => 6500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_17.jpg',
                'minutes_after_user' => 80,
            ],
            18 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 1, // Apple
                'device_model_id' => 14, // iPad Pro 12.9"
                'device_details' => 'Apple iPad Pro 12.9" 3rd Gen (64GB Wi-Fi, Space Gray, A12X Bionic, ProMotion 120Hz)',
                'condition' => 'working',
                'description' => 'Clean iCloud account, Face ID fully working, flawless 120Hz Liquid Retina display. Great for digital drawing, multimedia, and repair spare parts.',
                'estimated_weight' => 0.63,
                'carbon_footprint' => 1.45,
                'suggested_price' => 9000.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_18.jpg',
                'minutes_after_user' => 110,
            ],
            19 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 7, // LG
                'device_model_id' => 18, // LG UltraWide 34"
                'device_details' => 'LG UltraWide 34-inch Curved IPS LED Monitor (3440x1440 UWQHD, HDMI x 2, DisplayPort)',
                'condition' => 'minor_damage',
                'description' => 'Missing desktop stand, includes VESA mounting bracket and power supply. Display panel is completely scratch-free with zero dead pixels.',
                'estimated_weight' => 6.80,
                'carbon_footprint' => 15.64,
                'suggested_price' => 4800.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_19.jpg',
                'minutes_after_user' => 140,
            ],
        ];

        // 2. Insert or Update Listings
        $createdListings = [];

        foreach ($productsData as $prodIndex => $p) {
            $seller = User::where('email', $p['seller_email'])->first();
            if (!$seller) {
                continue;
            }

            // Calculate timestamp strictly after seller's creation / verification
            $sellerCreated = Carbon::parse($seller->created_at ?? '2026-10-14 19:26:32');
            $listingCreated = (clone $sellerCreated)->addMinutes($p['minutes_after_user'])->toDateTimeString();

            // Image path
            $photoUrl = '/storage/listings/' . $p['image_filename'];

            $listing = Listing::updateOrCreate(
                [
                    'user_id' => $seller->id,
                    'device_model_id' => $p['device_model_id'],
                ],
                [
                    'device_type_id' => $p['device_type_id'],
                    'device_brand_id' => $p['device_brand_id'],
                    'device_details' => $p['device_details'],
                    'condition' => $p['condition'],
                    'description' => $p['description'],
                    'estimated_weight' => $p['estimated_weight'],
                    'carbon_footprint' => $p['carbon_footprint'],
                    'suggested_price' => $p['suggested_price'],
                    'intended_action' => $p['intended_action'],
                    'handover_preference' => 'pickup',
                    'pickup_address' => 'Brgy. ' . ($seller->barangay ?? 'San Carlos City') . ', San Carlos City, Pangasinan 2420',
                    'status' => 'available',
                    'photos' => [$photoUrl],
                ]
            );

            // Force timestamps in DB
            DB::table('listings')->where('id', $listing->id)->update([
                'created_at' => $listingCreated,
                'updated_at' => $listingCreated,
            ]);

            // Connect listing_photos row
            $photo = ListingPhoto::updateOrCreate(
                [
                    'listing_id' => $listing->id,
                    'photo_url' => $photoUrl,
                ],
                [
                    'sort_order' => 0,
                ]
            );

            DB::table('listing_photos')->where('id', $photo->id)->update([
                'created_at' => $listingCreated,
                'updated_at' => $listingCreated,
            ]);

            // Log Product Creation in Audit Logs
            $deviceModelName = DB::table('device_models')->where('id', $p['device_model_id'])->value('model_name') ?? 'Device';
            DB::table('audit_logs')->updateOrInsert(
                [
                    'user_id' => $seller->id,
                    'action' => 'listing_created',
                    'model_type' => 'Listing',
                    'model_id' => $listing->id,
                ],
                [
                    'description' => "User {$seller->name} posted new e-waste listing: {$deviceModelName} ({$p['condition']}) for {$p['intended_action']}",
                    'ip_address' => $seller->ip_address ?? '136.158.12.83',
                    'user_agent' => $seller->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0',
                    'created_at' => $listingCreated,
                    'updated_at' => $listingCreated,
                ]
            );

            $createdListings[$prodIndex] = $listing;
        }

        // 3. Transactions Below 10 (Exactly 7 realistic transactions)
        $transactions = [
            // Transaction 1: Abe Austria buys Lenovo ThinkPad X1 from Mark Yvan Garcia
            1 => [
                'product_index' => 1,
                'buyer_email' => 'Abeaustria@gmail.com', // Abe Austria
                'bid_amount' => 1850.00,
                'proposed_method' => 'repair',
                'notes' => 'Will refurbish and replace thermal paste for community digital library deployment.',
                'pickup_location' => 'Tarece Barangay Plaza, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 2.5,
                'hours_to_respond' => 0.8,
                'hours_to_pickup' => 18.0,
                'messages' => [
                    ['buyer', 'Magandang araw po Sir Mark! Available pa po ba itong Lenovo ThinkPad X1? Kumpleto po ba ang charger?'],
                    ['seller', 'Magandang araw din po! Opo available pa po, tested and working yung battery at may kasamang original 65W Type-C charger.'],
                    ['buyer', 'Ayos po! Nag-submit po ako ng offer na ₱1,850. Pwede po bang ma-pickup bukas sa Tarece Plaza around 2 PM?'],
                    ['seller', 'Accepted po Sir Abe! Kitakits po bukas sa Tarece Barangay Plaza. Maraming salamat po!'],
                ],
            ],

            // Transaction 2: Kris Aquino buys Apple MacBook Pro 13" from Mia Shiela Grace Uson
            2 => [
                'product_index' => 2,
                'buyer_email' => 'krisaquino817@gmail.com', // Kris Aquino
                'bid_amount' => 3500.00,
                'proposed_method' => 'harvest',
                'notes' => 'For component recovery and salvage of working logic board and high-speed SSD.',
                'pickup_location' => 'San Carlos Town Plaza, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 3.2,
                'hours_to_respond' => 1.2,
                'hours_to_pickup' => 22.0,
                'messages' => [
                    ['buyer', 'Hello Mia! Inquire ko lang kung working pa po yung logic board at ports nitong MacBook Pro?'],
                    ['seller', 'Hello po Maam Kris! Yes po, 100% working po ang board and charging ports. Display lang po may vertical line.'],
                    ['buyer', 'Perfect for parts harvesting po sa computer laboratory. Nag-send na po ako ng bid offer ₱3,500.'],
                    ['seller', 'Thank you po Maam Kris, na-accept ko na po ang offer. Pwede po nating i-handover sa San Carlos Town Plaza.'],
                ],
            ],

            // Transaction 3: Benigno Garcia buys Dell OptiPlex from Darlyn Garcia
            3 => [
                'product_index' => 3,
                'buyer_email' => 'benignogarcia23@gmail.com', // Benigno Garcia
                'bid_amount' => 1300.00,
                'proposed_method' => 'repair',
                'notes' => 'Will install lightweight Linux OS and donate to local barangay youth desk.',
                'pickup_location' => 'Brgy. Turac Crossing, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 1.8,
                'hours_to_respond' => 0.5,
                'hours_to_pickup' => 16.0,
                'messages' => [
                    ['buyer', 'Kumusta po! Working pa po ba power supply at CPU nitong Dell OptiPlex?'],
                    ['seller', 'Opo, tested po ang BIOS boot at memory check. Walang sira ang motherboard.'],
                    ['buyer', 'Sige po Sir, kukunin ko na po for ₱1,300. Pwede po meetup sa Turac Crossing?'],
                    ['seller', 'Sige po kuya Benigno, see you po bukas ng umaga. Salamat po sa pagbenta!'],
                ],
            ],

            // Transaction 4: Jerwin Lomibao buys HP LaserJet Pro from Antonette Muñoz
            4 => [
                'product_index' => 5,
                'buyer_email' => 'lomibaojerwin@gmail.com', // Jerwin Lomibao
                'bid_amount' => 650.00,
                'proposed_method' => 'refine',
                'notes' => 'Metal and plastic extraction depot recycling in San Juan scrap sorting hub.',
                'pickup_location' => 'Brgy. Bocboc Proper, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 4.0,
                'hours_to_respond' => 1.5,
                'hours_to_pickup' => 20.0,
                'messages' => [
                    ['buyer', 'Hi Antonette! Kukunin po namin itong LaserJet printer for eco-refining at scrap component recovery.'],
                    ['seller', 'Hello po! Opo, andito pa po sa Bocboc. Kumpleto po yung mga internal metal rollers at circuits.'],
                    ['buyer', 'Nag-bid po ako ₱650 para ma-process agad sa collection truck namin.'],
                    ['seller', 'Accepted na po Sir Jerwin. Pwede na po ma-pickup anytime today.'],
                ],
            ],

            // Transaction 5: Jimmy Beltran buys LG UltraWide Monitor from Daisy Garcia
            5 => [
                'product_index' => 6,
                'buyer_email' => 'jimmybeltran@gmail.com', // Jimmy Beltran
                'bid_amount' => 2100.00,
                'proposed_method' => 'repair',
                'notes' => 'Repairing backlight array for dual-screen productivity workstation.',
                'pickup_location' => 'Mamarlao Road, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 2.0,
                'hours_to_respond' => 0.6,
                'hours_to_pickup' => 14.0,
                'messages' => [
                    ['buyer', 'Good day Daisy! May crack po ba yung screen panel nitong LG UltraWide o backlight lang talaga?'],
                    ['seller', 'Wala pong kahit anong basag or crack. Backlight diode lang po sa kaliwa ang mahina.'],
                    ['buyer', 'Kayang-kaya po ayusin yan. In-offeran ko po kayo ng ₱2,100.'],
                    ['seller', 'Deal po! Salamat po Sir Jimmy, naihanda ko na po ang box and cables para sa pickup.'],
                ],
            ],

            // Transaction 6: Abe Austria bids on Apple iPad Air from Vincent Agbuya (Accepted / In Progress)
            6 => [
                'product_index' => 11,
                'buyer_email' => 'Abeaustria@gmail.com', // Abe Austria
                'bid_amount' => 1600.00,
                'proposed_method' => 'repair',
                'notes' => 'Minor battery recalibration and clean install for student online education.',
                'pickup_location' => 'San Carlos Public Market, San Carlos City',
                'status' => 'accepted',
                'hours_after_listing' => 1.5,
                'hours_to_respond' => 0.4,
                'hours_to_pickup' => 24.0,
                'messages' => [
                    ['buyer', 'Sir Vincent, good afternoon! Genuine po ba battery nitong iPad Air?'],
                    ['seller', 'Opo Sir Abe, all-original po parts nito at hindi pa nabuksan. Factory reset na rin po.'],
                    ['buyer', 'Nag-submit na po ako ng bid offer ₱1,600 for inspection and pickup.'],
                    ['seller', 'Accepted na po! Set po natin pickup bukas sa tapat ng Public Market. Salamat!'],
                ],
            ],

            // Transaction 7: Kris Aquino bids on Dell U2720Q 4K Monitor from Mark Rejie Rosario (Accepted / In Progress)
            7 => [
                'product_index' => 9,
                'buyer_email' => 'krisaquino817@gmail.com', // Kris Aquino
                'bid_amount' => 1500.00,
                'proposed_method' => 'harvest',
                'notes' => 'Testing DisplayPort 4K 60Hz panel controller for e-waste diagnostic bench.',
                'pickup_location' => 'Brgy. Tamayo Road, San Carlos City',
                'status' => 'accepted',
                'hours_after_listing' => 2.8,
                'hours_to_respond' => 0.9,
                'hours_to_pickup' => 28.0,
                'messages' => [
                    ['buyer', 'Hi Mark Rejie! May kasama po bang power cord at stand itong Dell 4K monitor?'],
                    ['seller', 'Yes po Maam Kris, complete with original heavy-duty stand at power cable po.'],
                    ['buyer', 'Good to know. Offered ₱1,500 po, hope you can accept so we can test the DisplayPort.'],
                    ['seller', 'Offer accepted po Maam Kris! Ready for collection na po dito sa Tamayo.'],
                ],
            ],

            // 5 Offers / Transactions for seller@test.com from the 5 Buyers (1 offer each)
            // Transaction 8: Jimmy Beltran -> MacBook Air M1 (Product 15)
            8 => [
                'product_index' => 15,
                'buyer_email' => 'jimmybeltran@gmail.com', // Jimmy Beltran
                'bid_amount' => 11800.00,
                'proposed_method' => 'repair',
                'notes' => 'Replacing hinge bracket assembly and deploying for student coding workstation.',
                'pickup_location' => 'Brgy. Mabini Plaza, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 2.0,
                'hours_to_respond' => 0.5,
                'hours_to_pickup' => 18.0,
                'messages' => [
                    ['buyer', 'Good morning po Test Seller! Interesado po ako sa MacBook Air M1. Original po ba ang charger nito?'],
                    ['seller', 'Magandang umaga po Jimmy! Opo, original Apple 30W USB-C charger and cable ang kasama. Fully working ang logic board at keyboard.'],
                    ['buyer', 'Sige po, nag-offer po ako ng ₱11,800. Pwede po ba meetup sa Mabini Plaza mamayang 3 PM?'],
                    ['seller', 'Deal po sir! See you po sa Mabini Plaza. Salamat po!'],
                ],
            ],

            // Transaction 9: Jerwin Lomibao -> Dell OptiPlex Micro PC (Product 16)
            9 => [
                'product_index' => 16,
                'buyer_email' => 'lomibaojerwin@gmail.com', // Jerwin Lomibao
                'bid_amount' => 3900.00,
                'proposed_method' => 'repair',
                'notes' => 'Refurbishing small form factor PC for barangay community desk digitization.',
                'pickup_location' => 'San Carlos City Public Market, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 3.5,
                'hours_to_respond' => 0.8,
                'hours_to_pickup' => 22.0,
                'messages' => [
                    ['buyer', 'Hi seller, working po ba lahat ng USB ports at display output nitong Dell OptiPlex Micro?'],
                    ['seller', 'Hello Jerwin! Yes po, tested and working both DisplayPort and HDMI, bootable sa Windows 11.'],
                    ['buyer', 'Ayos po! In-offeran ko po kayo ng ₱3,900. Pickup ko po bukas ng umaga.'],
                    ['seller', 'Accepted po sir Jerwin! Naka-pack na po with power adapter. Ingat po sa biyahe.'],
                ],
            ],

            // Transaction 10: Benigno Garcia -> Samsung Galaxy S22 (Product 17)
            10 => [
                'product_index' => 17,
                'buyer_email' => 'benignogarcia23@gmail.com', // Benigno Garcia
                'bid_amount' => 6000.00,
                'proposed_method' => 'repair',
                'notes' => 'Replacing back glass panel and battery calibration for personal daily driver.',
                'pickup_location' => 'Brgy. Mabini Barangay Hall, San Carlos City',
                'status' => 'completed',
                'hours_after_listing' => 4.2,
                'hours_to_respond' => 0.6,
                'hours_to_pickup' => 16.0,
                'messages' => [
                    ['buyer', 'Good day po! Working po ba 100% yung screen digitizer at cameras nitong S22?'],
                    ['seller', 'Good day Benigno! Opo, back glass lang may crack. Flawless ang AMOLED display and 120Hz refresh.'],
                    ['buyer', 'Sige po, kukunin ko for ₱6,000 para palitan ko na lang ng back housing.'],
                    ['seller', 'Deal po Sir Benigno, accepted na po ang offer ninyo. Salamat po!'],
                ],
            ],

            // Transaction 11: Kris Aquino -> iPad Pro 12.9" (Product 18)
            11 => [
                'product_index' => 18,
                'buyer_email' => 'krisaquino817@gmail.com', // Kris Aquino
                'bid_amount' => 8500.00,
                'proposed_method' => 'repair',
                'notes' => 'Testing Apple Pencil latency and graphic apps for art studio workstation.',
                'pickup_location' => 'San Carlos Town Plaza, San Carlos City',
                'status' => 'accepted',
                'hours_after_listing' => 5.0,
                'hours_to_respond' => 0.7,
                'hours_to_pickup' => 30.0,
                'messages' => [
                    ['buyer', 'Hello po Test Seller! Clean iCloud and working po ba Apple Pencil compatibility nito?'],
                    ['seller', 'Yes Maam Kris! Signed out na po ang iCloud, factory reset, at tested sa Apple Pencil 2nd gen.'],
                    ['buyer', 'Great! Nag-submit po ako ng bid na ₱8,500 for inspection and pickup.'],
                    ['seller', 'Offer accepted po Maam Kris! Ihanda ko na po ang unit para sa ating pickup schedule.'],
                ],
            ],

            // Transaction 12: Abe Austria -> LG UltraWide 34" Monitor (Product 19)
            12 => [
                'product_index' => 19,
                'buyer_email' => 'Abeaustria@gmail.com', // Abe Austria
                'bid_amount' => 4500.00,
                'proposed_method' => 'harvest',
                'notes' => 'Harvesting UWQHD controller board and panel testing in e-waste repair lab.',
                'pickup_location' => 'Brgy. Mabini Crossing, San Carlos City',
                'status' => 'accepted',
                'hours_after_listing' => 6.0,
                'hours_to_respond' => 1.0,
                'hours_to_pickup' => 28.0,
                'messages' => [
                    ['buyer', 'Sir available pa po itong LG UltraWide? Kasama po ba power supply at HDMI cable?'],
                    ['seller', 'Opo Sir Abe! Complete with original power brick at high-speed HDMI cable.'],
                    ['buyer', 'Nag-offer po ako ₱4,500 for testing and pickup.'],
                    ['seller', 'Accepted na po Sir Abe! Available po ako for meetup dito sa Mabini Crossing. Salamat!'],
                ],
            ],
        ];

        foreach ($transactions as $tIndex => $t) {
            $listing = $createdListings[$t['product_index']] ?? null;
            if (!$listing) {
                continue;
            }

            $buyer = User::where('email', $t['buyer_email'])->first();
            $seller = User::find($listing->user_id);
            if (!$buyer || !$seller) {
                continue;
            }

            $listingCreatedDb = DB::table('listings')->where('id', $listing->id)->value('created_at');
            $listingTime = Carbon::parse($listingCreatedDb ?? $listing->created_at);
            $offerCreated = (clone $listingTime)->addHours($t['hours_after_listing'])->toDateTimeString();
            $offerResponded = (clone $listingTime)->addHours($t['hours_after_listing'] + $t['hours_to_respond'])->toDateTimeString();
            $pickupTime = (clone $listingTime)->addHours($t['hours_after_listing'] + $t['hours_to_respond'] + $t['hours_to_pickup'])->toDateTimeString();

            // Create Offer
            $offer = Offer::updateOrCreate(
                [
                    'listing_id' => $listing->id,
                    'buyer_id' => $buyer->id,
                ],
                [
                    'bid_amount' => $t['bid_amount'],
                    'proposed_method' => $t['proposed_method'],
                    'payment_method' => 'cash_pickup',
                    'cash_received_at' => $t['status'] === 'completed' ? $pickupTime : null,
                    'notes' => $t['notes'],
                    'proposed_pickup_date' => $pickupTime,
                    'pickup_location' => $t['pickup_location'],
                    'status' => $t['status'],
                    'responded_at' => $offerResponded,
                ]
            );

            DB::table('offers')->where('id', $offer->id)->update([
                'created_at' => $offerCreated,
                'updated_at' => $t['status'] === 'completed' ? $pickupTime : $offerResponded,
            ]);

            // Update Listing Match & Delivery Status
            DB::table('listings')->where('id', $listing->id)->update([
                'status' => $t['status'] === 'completed' ? 'delivered' : 'matched',
                'matched_buyer_id' => $buyer->id,
                'matched_at' => $offerResponded,
                'pickup_scheduled_at' => $pickupTime,
                'picked_up_at' => $t['status'] === 'completed' ? $pickupTime : null,
                'delivered_at' => $t['status'] === 'completed' ? $pickupTime : null,
                'processed_at' => $t['status'] === 'completed' ? Carbon::parse($pickupTime)->addHours(2)->toDateTimeString() : null,
                'updated_at' => $t['status'] === 'completed' ? $pickupTime : $offerResponded,
            ]);

            // Add Conversation Messages
            $msgBase = Carbon::parse($offerCreated);
            foreach ($t['messages'] as $mIndex => $msgData) {
                $sender = $msgData[0] === 'buyer' ? $buyer : $seller;
                $receiver = $msgData[0] === 'buyer' ? $seller : $buyer;
                $msgTime = (clone $msgBase)->addMinutes(($mIndex + 1) * 8)->toDateTimeString();

                $messageRecord = Message::firstOrCreate(
                    [
                        'offer_id' => $offer->id,
                        'sender_id' => $sender->id,
                        'message' => $msgData[1],
                    ],
                    [
                        'receiver_id' => $receiver->id,
                        'is_read' => true,
                        'read_at' => Carbon::parse($msgTime)->addMinutes(1)->toDateTimeString(),
                    ]
                );

                DB::table('messages')->where('id', $messageRecord->id)->update([
                    'created_at' => $msgTime,
                    'updated_at' => $msgTime,
                ]);
            }

            // Create In-App Notifications
            // 1. Seller received offer
            $notif1 = Notification::notify(
                $seller,
                'offer_received',
                'New Offer Received! 💰',
                "Buyer {$buyer->name} submitted a bid of ₱" . number_format($t['bid_amount'], 2) . " for your listing.",
                ['offer_id' => $offer->id, 'listing_id' => $listing->id]
            );
            DB::table('notifications')->where('id', $notif1->id)->update([
                'created_at' => $offerCreated,
                'updated_at' => $offerCreated,
            ]);

            // 2. Buyer's offer was accepted
            $notif2 = Notification::notify(
                $buyer,
                'offer_accepted',
                'Offer Accepted! 🎉',
                "Seller {$seller->name} accepted your offer of ₱" . number_format($t['bid_amount'], 2) . " for {$listing->description}.",
                ['offer_id' => $offer->id, 'listing_id' => $listing->id]
            );
            DB::table('notifications')->where('id', $notif2->id)->update([
                'created_at' => $offerResponded,
                'updated_at' => $offerResponded,
            ]);

            if ($t['status'] === 'completed') {
                // 3. Completed notifications
                $notif3 = Notification::notify(
                    $seller,
                    'transaction_completed',
                    'Item Handover Complete! 🌿',
                    "Transaction #{$offer->id} successfully completed. You diverted {$listing->estimated_weight} kg of electronic waste!",
                    ['offer_id' => $offer->id, 'listing_id' => $listing->id]
                );
                DB::table('notifications')->where('id', $notif3->id)->update([
                    'created_at' => $pickupTime,
                    'updated_at' => $pickupTime,
                ]);

                $notif4 = Notification::notify(
                    $buyer,
                    'transaction_completed',
                    'Transaction Completed & Certified! ♻️',
                    "You received {$listing->description} and saved {$listing->carbon_footprint} kg CO₂ from the environment.",
                    ['offer_id' => $offer->id, 'listing_id' => $listing->id]
                );
                DB::table('notifications')->where('id', $notif4->id)->update([
                    'created_at' => $pickupTime,
                    'updated_at' => $pickupTime,
                ]);
            }

            // Audit Logs for the Transaction
            DB::table('audit_logs')->updateOrInsert(
                [
                    'user_id' => $buyer->id,
                    'action' => 'offer_created',
                    'model_type' => 'Offer',
                    'model_id' => $offer->id,
                ],
                [
                    'description' => "Buyer {$buyer->name} submitted bid of ₱" . number_format($t['bid_amount'], 2) . " on listing #{$listing->id}",
                    'ip_address' => $buyer->ip_address ?? '120.28.9.44',
                    'user_agent' => $buyer->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                    'created_at' => $offerCreated,
                    'updated_at' => $offerCreated,
                ]
            );

            DB::table('audit_logs')->updateOrInsert(
                [
                    'user_id' => $seller->id,
                    'action' => 'offer_accepted',
                    'model_type' => 'Offer',
                    'model_id' => $offer->id,
                ],
                [
                    'description' => "Seller {$seller->name} accepted offer #{$offer->id} (₱" . number_format($t['bid_amount'], 2) . ") from {$buyer->name}",
                    'ip_address' => $seller->ip_address ?? '136.158.12.83',
                    'user_agent' => $seller->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                    'created_at' => $offerResponded,
                    'updated_at' => $offerResponded,
                ]
            );

            if ($t['status'] === 'completed') {
                DB::table('audit_logs')->updateOrInsert(
                    [
                        'user_id' => $seller->id,
                        'action' => 'item_picked_up',
                        'model_type' => 'Listing',
                        'model_id' => $listing->id,
                    ],
                    [
                        'description' => "Listing #{$listing->id} handed over to {$buyer->name} at {$t['pickup_location']}",
                        'ip_address' => $seller->ip_address ?? '136.158.12.83',
                        'user_agent' => $seller->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                        'created_at' => $pickupTime,
                        'updated_at' => $pickupTime,
                    ]
                );

                $completionTime = Carbon::parse($pickupTime)->addMinutes(15)->toDateTimeString();
                DB::table('audit_logs')->updateOrInsert(
                    [
                        'user_id' => $buyer->id,
                        'action' => 'transaction_completed',
                        'model_type' => 'Offer',
                        'model_id' => $offer->id,
                    ],
                    [
                        'description' => "Transaction #{$offer->id} completed. {$listing->estimated_weight} kg diverted from landfill ({$listing->carbon_footprint} kg CO₂ saved)",
                        'ip_address' => $buyer->ip_address ?? '120.28.9.44',
                        'user_agent' => $buyer->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                        'created_at' => $completionTime,
                        'updated_at' => $completionTime,
                    ]
                );

                // Create Impact Log for completed transaction
                $certToken = 'CERT-' . strtoupper(Str::random(12));
                $impact = ImpactLog::updateOrCreate(
                    [
                        'listing_id' => $listing->id,
                        'offer_id' => $offer->id,
                    ],
                    [
                        'seller_id' => $seller->id,
                        'buyer_id' => $buyer->id,
                        'device_category' => $listing->deviceType?->name ?? 'Electronics',
                        'device_weight' => $listing->estimated_weight,
                        'processing_method' => $t['proposed_method'],
                        'co2_saved' => $listing->carbon_footprint,
                        'landfill_diverted_weight' => $listing->estimated_weight,
                        'materials_recovered_weight' => round($listing->estimated_weight * 0.85, 2),
                        'gold_recovered' => 0.0004,
                        'copper_recovered' => round($listing->estimated_weight * 0.22, 2),
                        'aluminum_recovered' => round($listing->estimated_weight * 0.35, 2),
                        'plastic_recovered' => round($listing->estimated_weight * 0.28, 2),
                        'certificate_token' => $certToken,
                        'status' => 'certified',
                        'certified_at' => Carbon::parse($pickupTime)->addMinutes(20)->toDateTimeString(),
                    ]
                );

                DB::table('impact_logs')->where('id', $impact->id)->update([
                    'created_at' => $pickupTime,
                    'updated_at' => $pickupTime,
                ]);

                // Create Commission Record for completed transaction
                $gross = (float) $t['bid_amount'];
                $rate = 5.0; // Standard 5% platform fee
                $fee = round($gross * ($rate / 100), 2);
                $net = round($gross - $fee, 2);

                Commission::updateOrCreate(
                    [
                        'offer_id' => $offer->id,
                    ],
                    [
                        'payment_id' => null,
                        'seller_id' => $seller->id,
                        'buyer_id' => $buyer->id,
                        'gross_amount' => $gross,
                        'commission_rate' => $rate,
                        'commission_amount' => $fee,
                        'seller_net_amount' => $net,
                        'payment_method' => 'cash_pickup',
                        'status' => 'collected',
                        'collected_at' => $pickupTime,
                        'notes' => 'Platform commission for completed handover #' . $offer->id,
                        'created_at' => $pickupTime,
                        'updated_at' => $pickupTime,
                    ]
                );
            }
        }

        // 4. Enrich general user activity logs (Logins, Search Queries, Profile Views)
        $searchQueries = [
            'laptop parts San Carlos',
            'broken LCD monitor for repair',
            'desktop tower power supply',
            'e-waste drop off point Pangasinan',
            'RAM DDR4 motherboard scrap',
            'smartphone battery replacement',
            'bulk electronics recycling depot',
        ];

        $activeUsers = User::whereIn('id', [2, 16, 17, 18, 19, 20, 21, 22, 24, 25, 26, 28, 29, 32, 39, 40])->get();
        foreach ($activeUsers as $u) {
            $baseTime = Carbon::parse($u->created_at ?? '2026-10-14 20:00:00');
            $loginTime = (clone $baseTime)->addHours(4)->toDateTimeString();

            // 1. User login log
            DB::table('audit_logs')->updateOrInsert(
                [
                    'user_id' => $u->id,
                    'action' => 'user_login',
                    'created_at' => $loginTime,
                ],
                [
                    'model_type' => 'User',
                    'model_id' => $u->id,
                    'description' => "User {$u->name} authenticated successfully into eBenta platform",
                    'ip_address' => $u->ip_address ?? '120.28.9.44',
                    'user_agent' => $u->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                    'updated_at' => $loginTime,
                ]
            );

            // 2. Search query log for buyers
            if ($u->role === 'buyer') {
                $query = $searchQueries[$u->id % count($searchQueries)];
                $searchTime = (clone $baseTime)->addHours(5)->toDateTimeString();
                DB::table('audit_logs')->updateOrInsert(
                    [
                        'user_id' => $u->id,
                        'action' => 'search_performed',
                        'created_at' => $searchTime,
                    ],
                    [
                        'model_type' => 'Listing',
                        'model_id' => $u->id,
                        'description' => "User {$u->name} searched marketplace catalogue for '{$query}'",
                        'ip_address' => $u->ip_address ?? '120.28.9.44',
                        'user_agent' => $u->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
                        'updated_at' => $searchTime,
                    ]
                );
            }
        }
    }
}
