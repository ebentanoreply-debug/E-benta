<?php

use App\Models\DeviceBrand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\Listing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Simplifies existing product names, adds 29 realistic e-waste products without images
     * (ready for manual image upload/editing by the seller), inserts corresponding audit logs
     * strictly dated between October 14 and 18, 2026 based on the seller's account creation date,
     * and guarantees photo/image edits are excluded from audit logs.
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

        // 2. Definition of exactly 29 additional products WITHOUT images
        $newProducts = [
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
                'minutes_after_user' => 45,
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
                'minutes_after_user' => 30,
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
                'minutes_after_user' => 50,
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
                'minutes_after_user' => 35,
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
                'minutes_after_user' => 40,
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
                'minutes_after_user' => 55,
            ],
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
                'minutes_after_user' => 25,
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
                'minutes_after_user' => 48,
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
                'minutes_after_user' => 32,
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
                'minutes_after_user' => 60,
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
                'minutes_after_user' => 42,
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
                'minutes_after_user' => 38,
            ],
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
                'minutes_after_user' => 52,
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
                'minutes_after_user' => 65,
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
                'minutes_after_user' => 70,
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
                'minutes_after_user' => 45,
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
                'minutes_after_user' => 40,
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
                'minutes_after_user' => 35,
            ],
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
                'minutes_after_user' => 50,
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
                'minutes_after_user' => 60,
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
                'minutes_after_user' => 45,
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
                'minutes_after_user' => 55,
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
                'minutes_after_user' => 48,
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
                'minutes_after_user' => 60,
            ],
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
                'minutes_after_user' => 40,
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
                'minutes_after_user' => 30,
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
                'minutes_after_user' => 52,
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
                'minutes_after_user' => 36,
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
                'minutes_after_user' => 85,
            ],
        ];

        // 3. Cache device lookup tables for efficient mapping
        $deviceTypes = DB::table('device_types')->pluck('id', 'name');
        $deviceBrands = DB::table('device_brands')->pluck('id', 'name');
        $deviceModels = DB::table('device_models')->pluck('id', 'model_name');

        foreach ($newProducts as $p) {
            $seller = DB::table('users')->where('email', $p['seller_email'])->first()
                ?? DB::table('users')->where('role', 'seller')->first();

            if (!$seller) {
                continue;
            }

            // Resolve relational Foreign Keys safely
            $typeId = $deviceTypes[$p['type_name']] ?? (DB::table('device_types')->first()->id ?? 1);
            $brandId = $deviceBrands[$p['brand_name']] ?? (DB::table('device_brands')->first()->id ?? 1);
            $modelId = !empty($p['model_name']) && isset($deviceModels[$p['model_name']])
                ? $deviceModels[$p['model_name']]
                : null;

            // Strict timestamp logic: depends on when seller account was created, between Oct 14 and Oct 18, 2026
            $sellerCreated = $seller->created_at ? Carbon::parse($seller->created_at) : Carbon::create(2026, 10, 14, 10, 0, 0);
            if ($sellerCreated->lt(Carbon::create(2026, 10, 14, 8, 0, 0))) {
                $sellerCreated = Carbon::create(2026, 10, 14, 9, 30, 0);
            } elseif ($sellerCreated->gt(Carbon::create(2026, 10, 18, 21, 0, 0))) {
                $sellerCreated = Carbon::create(2026, 10, 18, 16, 45, 0);
            }

            $listingCreated = (clone $sellerCreated)->addMinutes($p['minutes_after_user']);
            if ($listingCreated->hour >= 22) {
                $listingCreated = (clone $sellerCreated)->subMinutes(10);
            }
            $createdStr = $listingCreated->format('Y-m-d H:i:s');

            $pickupAddress = 'Brgy. ' . ($seller->barangay ?? 'San Carlos City') . ', San Carlos City, Pangasinan 2420';

            // Check if listing already exists to ensure idempotency
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
                ]);
            }

            // CRITICAL: Ensure NO photos exist for these 29 products so user can edit and add images manually!
            DB::table('listing_photos')->where('listing_id', $listingId)->delete();

            // Insert audit log strictly dated October 14 - 18, 2026 based on the seller's account timestamp
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

        // 4. Exclude any photo/image modification entries from audit logs
        DB::table('audit_logs')
            ->where('model_type', 'ListingPhoto')
            ->orWhere('action', 'like', '%photo%')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to preserve listing customizations
    }
};
