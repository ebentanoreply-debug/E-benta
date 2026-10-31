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

        // 1. Definition of 48 Products (1-19 existing with simple names, 20-48 new without images)
        $productsData = [
            1 => [
                'seller_email' => 'markyvangarcia@gmail.com', // Mark Yvan Garcia (Tarece)
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 7, // Lenovo
                'device_model_id' => 5, // Lenovo ThinkPad X1
                'device_details' => 'Apple iPhone 11',
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
                'device_details' => 'Apple iPad Air',
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
                'device_details' => 'Samsung Galaxy Tab A8',
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
                'device_details' => 'Samsung Galaxy S21',
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
                'device_details' => 'Xiaomi Redmi Note 10',
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
                'device_details' => 'Samsung Galaxy Tab S7',
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
                'device_details' => 'OPPO Reno 4',
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
                'device_details' => 'Apple iPhone 12',
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
                'device_details' => 'Huawei MatePad T10',
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
                'device_details' => 'Realme C25',
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
                'device_details' => 'Apple iPad Air',
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
                'device_details' => 'Vivo Y20',
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
                'device_details' => 'Apple iPhone 13',
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
                'device_details' => 'Samsung Galaxy Tab S7',
                'condition' => 'working',
                'description' => 'Samsung flagship tablet with original magnetic S-Pen included. Snapdragon 865+, quad AKG speakers, expandable MicroSD slot. Flawless working unit.',
                'estimated_weight' => 0.50,
                'carbon_footprint' => 1.15,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_14.jpg',
                'minutes_after_user' => 52,
            ],

            // 5 Products specifically for seller@test.com (Test Seller) - Spread across Oct 13 to Oct 16
            15 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 1, // Apple
                'device_model_id' => 2, // MacBook Air M1
                'device_details' => 'Apple iPhone 13 Pro',
                'condition' => 'minor_damage',
                'description' => 'Broken left hinge mechanism but Retina display panel and M1 logic board function 100%. Battery health at 88%. Good for student or home workstation.',
                'estimated_weight' => 1.29,
                'carbon_footprint' => 2.97,
                'suggested_price' => 12500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_15.jpg',
                'exact_date' => '2026-10-13 09:00:00',
            ],
            16 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 2, // Dell
                'device_model_id' => 8, // Dell OptiPlex
                'device_details' => 'Apple iPad 9th Gen',
                'condition' => 'working',
                'description' => 'Compact mini PC decommissioned from office. Clean internals, tested USB and DisplayPort video output. Fully bootable to Windows 11.',
                'estimated_weight' => 1.18,
                'carbon_footprint' => 2.71,
                'suggested_price' => 4200.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_16.jpg',
                'exact_date' => '2026-10-14 09:30:00',
            ],
            17 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 6, // Samsung
                'device_model_id' => 13, // Samsung Galaxy S22
                'device_details' => 'Samsung Galaxy S22',
                'condition' => 'minor_damage',
                'description' => 'Hairline crack on back glass cover. Dynamic AMOLED screen, camera modules, ultrasonic fingerprint scanner, and motherboard are completely flawless.',
                'estimated_weight' => 0.17,
                'carbon_footprint' => 0.39,
                'suggested_price' => 6500.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_17.jpg',
                'exact_date' => '2026-10-15 09:30:00',
            ],
            18 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 1, // Apple
                'device_model_id' => 14, // iPad Pro 12.9"
                'device_details' => 'iPad Pro 12.9"',
                'condition' => 'working',
                'description' => 'Clean iCloud account, Face ID fully working, flawless 120Hz Liquid Retina display. Great for digital drawing, multimedia, and repair spare parts.',
                'estimated_weight' => 0.63,
                'carbon_footprint' => 1.45,
                'suggested_price' => 9000.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_18.jpg',
                'exact_date' => '2026-10-16 10:00:00',
            ],
            19 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 7, // LG
                'device_model_id' => 18, // LG UltraWide 34"
                'device_details' => 'Samsung Galaxy Tab S6 Lite',
                'condition' => 'minor_damage',
                'description' => 'Missing desktop stand, includes VESA mounting bracket and power supply. Display panel is completely scratch-free with zero dead pixels.',
                'estimated_weight' => 6.80,
                'carbon_footprint' => 15.64,
                'suggested_price' => 4800.00,
                'intended_action' => 'sell',
                'image_filename' => 'product_19.jpg',
                'exact_date' => '2026-10-13 10:15:00',
            ],

            // 29 NEW PRODUCTS (Indices 20 - 48) WITHOUT IMAGES - Spread across Oct 14 - Oct 18
            20 => [
                'seller_email' => 'ron02naadat@gmail.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 9, // Acer
                'device_model_id' => null,
                'device_details' => 'Xiaomi Redmi 9A',
                'condition' => 'working',
                'description' => 'Working Acer Aspire 5 with Intel Core i3, 8GB RAM, and 256GB SSD. Minor wear on palm rest. Includes original charger.',
                'estimated_weight' => 1.80,
                'carbon_footprint' => 4.14,
                'suggested_price' => 3500.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 09:30:00',
            ],
            21 => [
                'seller_email' => 'jimboymelican12@gmail.com',
                'device_type_id' => 8, // Printer
                'device_brand_id' => 12, // Canon
                'device_model_id' => 25, // Canon PIXMA
                'device_details' => 'Samsung Galaxy A12',
                'condition' => 'minor_damage',
                'description' => 'Eco-tank all-in-one printer. Scanner and feeder fully operational; printhead needs minor flushing.',
                'estimated_weight' => 5.20,
                'carbon_footprint' => 11.96,
                'suggested_price' => 1200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 11:15:00',
            ],
            22 => [
                'seller_email' => 'carinojoseph2489@gmail.com',
                'device_type_id' => 7, // Mouse
                'device_brand_id' => 11, // Logitech
                'device_model_id' => 22, // Logitech MX Master 3
                'device_details' => 'Realme 5 Pro',
                'condition' => 'working',
                'description' => 'Ergonomic wireless productivity mouse. Electromagnetic scroll wheel and battery tested 100% working.',
                'estimated_weight' => 0.14,
                'carbon_footprint' => 0.32,
                'suggested_price' => 1500.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 13:45:00',
            ],
            23 => [
                'seller_email' => 'mclestersoriano43@gmail.com',
                'device_type_id' => 9, // Router
                'device_brand_id' => 13, // TP-Link
                'device_model_id' => 26, // TP-Link WiFi 6 Router
                'device_details' => 'OPPO F11 Pro',
                'condition' => 'working',
                'description' => 'Dual-band Gigabit Wi-Fi 6 wireless router with 4 high-gain antennas. Reset to factory default.',
                'estimated_weight' => 0.55,
                'carbon_footprint' => 1.27,
                'suggested_price' => 1400.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 15:20:00',
            ],
            24 => [
                'seller_email' => 'shinjay.rak@gmail.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 8, // Sony
                'device_model_id' => null,
                'device_details' => 'Apple iPad 8th Gen',
                'condition' => 'working',
                'description' => 'Clean 500GB PS4 console. Tested HDMI output, optical drive, and Wi-Fi connection. Includes power cord.',
                'estimated_weight' => 2.10,
                'carbon_footprint' => 4.83,
                'suggested_price' => 4500.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 16:50:00',
            ],
            25 => [
                'seller_email' => 'michellecarino4@gmail.com',
                'device_type_id' => 6, // Keyboard
                'device_brand_id' => 1, // Apple
                'device_model_id' => 20, // Apple Magic Keyboard
                'device_details' => 'Huawei Nova 7i',
                'condition' => 'working',
                'description' => 'Slim wireless Bluetooth keyboard with rechargeable battery. Scissor mechanism keys fully responsive.',
                'estimated_weight' => 0.24,
                'carbon_footprint' => 0.55,
                'suggested_price' => 1800.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-14 18:10:00',
            ],
            26 => [
                'seller_email' => 'johnmichaelsantos@gmail.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 3, // Dell
                'device_model_id' => 3, // Dell XPS 13
                'device_details' => 'Samsung Galaxy Tab A7 Lite',
                'condition' => 'minor_damage',
                'description' => 'Core i5 8th Gen laptop with 15.6" anti-glare screen. Weak battery (requires AC adapter plugged in).',
                'estimated_weight' => 2.00,
                'carbon_footprint' => 4.60,
                'suggested_price' => 2800.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-15 08:45:00',
            ],
            27 => [
                'seller_email' => 'joshuareyes23@gmail.com',
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 2, // Samsung
                'device_model_id' => 16, // Galaxy Tab S7
                'device_details' => 'Samsung Galaxy Tab A8',
                'condition' => 'working',
                'description' => '10.5-inch entertainment tablet with quad speakers and Dolby Atmos. Good battery health, clean firmware.',
                'estimated_weight' => 0.51,
                'carbon_footprint' => 1.17,
                'suggested_price' => 2500.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-15 10:20:00',
            ],
            28 => [
                'seller_email' => 'angelicamendoza05@gmail.com',
                'device_type_id' => 8, // Printer
                'device_brand_id' => 4, // HP
                'device_model_id' => 24, // HP LaserJet Pro
                'device_details' => 'Infinix Hot 10',
                'condition' => 'non_functional',
                'description' => 'Ink cartridge carriage motor jammed. Clean casing, power module, and electronic board for parts harvest.',
                'estimated_weight' => 3.42,
                'carbon_footprint' => 7.87,
                'suggested_price' => 450.00,
                'intended_action' => 'recycle',
                'image_filename' => null,
                'exact_date' => '2026-10-15 12:35:00',
            ],
            29 => [
                'seller_email' => 'nicolevillanueva@gmail.com',
                'device_type_id' => 9, // Router
                'device_brand_id' => 14, // Netgear
                'device_model_id' => 27, // Netgear Nighthawk
                'device_details' => 'Vivo V20',
                'condition' => 'working',
                'description' => 'High performance smart Wi-Fi router. 1GHz dual-core processor, USB 3.0 port for external media sharing.',
                'estimated_weight' => 0.75,
                'carbon_footprint' => 1.73,
                'suggested_price' => 1100.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-15 14:15:00',
            ],
            30 => [
                'seller_email' => 'adrianflores08@gmail.com',
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 5, // ASUS
                'device_model_id' => 19, // ASUS ProArt 32"
                'device_details' => 'Apple iPad Mini 5',
                'condition' => 'minor_damage',
                'description' => 'Color-accurate creator monitor with slight stand swivel looseness. Screen panel 100% scratch-free.',
                'estimated_weight' => 6.20,
                'carbon_footprint' => 14.26,
                'suggested_price' => 3200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-15 16:00:00',
            ],
            31 => [
                'seller_email' => 'princessmaecastillo@gmail.com',
                'device_type_id' => 6, // Keyboard
                'device_brand_id' => 5, // ASUS
                'device_model_id' => 21, // Mechanical RGB Keyboard
                'device_details' => 'Xiaomi Poco X3 Pro',
                'condition' => 'working',
                'description' => 'Tactile blue switch mechanical keyboard with per-key RGB backlighting and braided detachable USB cable.',
                'estimated_weight' => 0.95,
                'carbon_footprint' => 2.19,
                'suggested_price' => 900.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-15 17:30:00',
            ],
            32 => [
                'seller_email' => 'markanthonyrivera@gmail.com',
                'device_type_id' => 7, // Mouse
                'device_brand_id' => 1, // Apple
                'device_model_id' => 23, // Apple Magic Mouse
                'device_details' => 'Samsung Galaxy J7 Prime',
                'condition' => 'working',
                'description' => 'Multi-Touch surface mouse with built-in rechargeable lithium-ion battery. Seamless gesture navigation.',
                'estimated_weight' => 0.10,
                'carbon_footprint' => 0.23,
                'suggested_price' => 1200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 09:10:00',
            ],
            33 => [
                'seller_email' => 'jerichofernandez@gmail.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 7, // Lenovo
                'device_model_id' => 5, // Lenovo ThinkPad X1
                'device_details' => 'Lenovo Tab M10',
                'condition' => 'working',
                'description' => 'Everyday computing laptop with AMD Ryzen 3, 8GB DDR4 RAM, and 512GB NVMe SSD. Clean webcam with privacy shutter.',
                'estimated_weight' => 1.70,
                'carbon_footprint' => 3.91,
                'suggested_price' => 3800.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 10:45:00',
            ],
            34 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 1, // Apple
                'device_model_id' => 7, // iMac 27"
                'device_details' => 'Apple iPad Pro 11"',
                'condition' => 'minor_damage',
                'description' => 'All-in-one desktop with 5K Retina display. Internal HDD replaced with fast 500GB SSD. Minor glass chip at corner.',
                'estimated_weight' => 8.90,
                'carbon_footprint' => 20.47,
                'suggested_price' => 6500.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 12:15:00',
            ],
            35 => [
                'seller_email' => 'samanthalopez21@gmail.com',
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 2, // Samsung
                'device_model_id' => 12, // Samsung Galaxy S21
                'device_details' => 'Samsung Galaxy S20 FE',
                'condition' => 'working',
                'description' => 'Tested 120Hz Super AMOLED display, 128GB internal storage, triple rear camera setup. Openline to all SIMs.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 3200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 14:00:00',
            ],
            36 => [
                'seller_email' => 'carlomigelaquino@gmail.com',
                'device_type_id' => 8, // Printer
                'device_brand_id' => 12, // Canon
                'device_model_id' => 25, // Canon PIXMA
                'device_details' => 'Canon imageCLASS LBP6030w',
                'condition' => 'working',
                'description' => 'Compact monochrome laser printer with built-in Wi-Fi. Fast 18 ppm output, sharp black text reproduction.',
                'estimated_weight' => 5.00,
                'carbon_footprint' => 11.50,
                'suggested_price' => 1800.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 15:40:00',
            ],
            37 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 3, // Dell
                'device_model_id' => 17, // Dell U2720Q 27"
                'device_details' => 'Dell SE2422H 24" Monitor',
                'condition' => 'working',
                'description' => '24-inch Full HD 75Hz monitor with AMD FreeSync. Slim bezels, HDMI and VGA input ports. Includes power cord.',
                'estimated_weight' => 3.80,
                'carbon_footprint' => 8.74,
                'suggested_price' => 2100.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-16 17:15:00',
            ],
            38 => [
                'seller_email' => 'jasminetorres14@gmail.com',
                'device_type_id' => 1, // Laptop
                'device_brand_id' => 4, // HP
                'device_model_id' => 4, // HP Pavilion 15
                'device_details' => 'HP Pavilion 15 Gaming',
                'condition' => 'minor_damage',
                'description' => 'Core i5 gaming laptop with GTX 1050 graphics. Minor keycap wear on W-A-S-D keys; cooling and motherboard excellent.',
                'estimated_weight' => 2.20,
                'carbon_footprint' => 5.06,
                'suggested_price' => 4200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 08:30:00',
            ],
            39 => [
                'seller_email' => 'renzomartinez@gmail.com',
                'device_type_id' => 4, // Tablet
                'device_brand_id' => 1, // Apple
                'device_model_id' => 15, // iPad Air
                'device_details' => 'Apple iPad Mini 5',
                'condition' => 'working',
                'description' => '7.9-inch Retina display with True Tone. A12 Bionic chip, 64GB storage, supports Apple Pencil 1st Gen.',
                'estimated_weight' => 0.30,
                'carbon_footprint' => 0.69,
                'suggested_price' => 3600.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 10:15:00',
            ],
            40 => [
                'seller_email' => 'andreasalazar09@gmail.com',
                'device_type_id' => 7, // Mouse
                'device_brand_id' => 11, // Logitech
                'device_model_id' => 22, // Logitech MX Master 3
                'device_details' => 'Logitech G502 Hero',
                'condition' => 'working',
                'description' => 'High performance gaming mouse with 25K DPI sensor, 11 programmable buttons, and adjustable weight tuning.',
                'estimated_weight' => 0.12,
                'carbon_footprint' => 0.28,
                'suggested_price' => 850.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 11:50:00',
            ],
            41 => [
                'seller_email' => 'vincentgonzales@gmail.com',
                'device_type_id' => 9, // Router
                'device_brand_id' => 13, // TP-Link
                'device_model_id' => 26, // TP-Link WiFi 6 Router
                'device_details' => 'TP-Link Deco Mesh WiFi',
                'condition' => 'working',
                'description' => 'Whole home mesh Wi-Fi system unit. Seamless roaming coverage up to 2,000 sq ft. Tested and updated to latest firmware.',
                'estimated_weight' => 0.60,
                'carbon_footprint' => 1.38,
                'suggested_price' => 1600.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 13:30:00',
            ],
            42 => [
                'seller_email' => 'kimberlynavarro@gmail.com',
                'device_type_id' => 5, // Monitor
                'device_brand_id' => 8, // Sony
                'device_model_id' => null,
                'device_details' => 'Sony Bravia LED Display 32"',
                'condition' => 'minor_damage',
                'description' => '32-inch commercial display panel for CCTV or secondary monitor setup. Missing remote, buttons on panel fully functional.',
                'estimated_weight' => 5.50,
                'carbon_footprint' => 12.65,
                'suggested_price' => 2400.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 15:10:00',
            ],
            43 => [
                'seller_email' => 'trishiafernandez12@gmail.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 3, // Dell
                'device_model_id' => 8, // Dell OptiPlex
                'device_details' => 'Dell OptiPlex 3050 Tower',
                'condition' => 'working',
                'description' => 'Core i5 7th Gen business desktop tower, 8GB DDR4 RAM, 1TB HDD. Clean power supply unit and working DVD-RW drive.',
                'estimated_weight' => 7.20,
                'carbon_footprint' => 16.56,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-17 16:45:00',
            ],
            44 => [
                'seller_email' => 'angelagarcia08@gmail.com',
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 2, // Samsung
                'device_model_id' => 12, // Samsung Galaxy S21
                'device_details' => 'Samsung Galaxy A52',
                'condition' => 'minor_damage',
                'description' => '6.5" Super AMOLED 90Hz phone. Minor glass back scuffs. Quad 64MP OIS camera, speakers, and fast charging tested.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 2100.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-18 09:15:00',
            ],
            45 => [
                'seller_email' => 'markmendoza17@gmail.com',
                'device_type_id' => 10, // Cable / Wire
                'device_brand_id' => 3, // Dell
                'device_model_id' => null,
                'device_details' => 'Apple iPad Mini 4',
                'condition' => 'non_functional',
                'description' => 'Heavy lot of assorted copper power cords, VGA/DVI cables, and electrical wiring suited for e-waste scrap recycling.',
                'estimated_weight' => 4.50,
                'carbon_footprint' => 10.35,
                'suggested_price' => 350.00,
                'intended_action' => 'recycle',
                'image_filename' => null,
                'exact_date' => '2026-10-18 10:40:00',
            ],
            46 => [
                'seller_email' => 'camilleflores25@gmail.com',
                'device_type_id' => 8, // Printer
                'device_brand_id' => 4, // HP
                'device_model_id' => 24, // HP LaserJet Pro
                'device_details' => 'Lenovo Yoga Smart Tab',
                'condition' => 'non_functional',
                'description' => 'Classic laser printer with bad fuser assembly. Power supply board and copper coils intact for component salvaging.',
                'estimated_weight' => 5.70,
                'carbon_footprint' => 13.11,
                'suggested_price' => 600.00,
                'intended_action' => 'recycle',
                'image_filename' => null,
                'exact_date' => '2026-10-18 12:20:00',
            ],
            47 => [
                'seller_email' => 'miguelramos11@gmail.com',
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => 1, // Apple
                'device_model_id' => 11, // iPhone 12
                'device_details' => 'Apple iPhone 11',
                'condition' => 'minor_damage',
                'description' => 'Liquid Retina HD display with hairline crack in bottom corner. TrueDepth camera and Face ID working, battery health 79%.',
                'estimated_weight' => 0.19,
                'carbon_footprint' => 0.44,
                'suggested_price' => 3900.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-18 14:10:00',
            ],
            48 => [
                'seller_email' => 'seller@test.com',
                'device_type_id' => 2, // Desktop Computer
                'device_brand_id' => 7, // Lenovo
                'device_model_id' => 5, // Lenovo ThinkPad X1
                'device_details' => 'Samsung Galaxy Tab S5e',
                'condition' => 'working',
                'description' => 'Super AMOLED 10.5-inch tablet weighing only 400g. AKG quad speakers and biometric reader tested. Clean firmware, responsive touchscreen.',
                'estimated_weight' => 0.40,
                'carbon_footprint' => 0.92,
                'suggested_price' => 2600.00,
                'intended_action' => 'sell',
                'image_filename' => null,
                'exact_date' => '2026-10-18 16:00:00',
            ],
            49 => [
                'seller_email' => 'andreabautista09@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 10,
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 10x Assorted Android Phones (Repair & Scrap)',
                'condition' => 'minor_damage',
                'description' => 'Lot of 10 assorted Android smartphones (Samsung, Xiaomi, Vivo, and OPPO). 6 units power on with cracked screens or battery degradation; 4 units for parts and board-level harvesting.',
                'estimated_weight' => 1.85,
                'carbon_footprint' => 4.26,
                'suggested_price' => 1500.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'image_filename' => null,
                'exact_date' => '2026-10-14 10:15:00',
            ],
            50 => [
                'seller_email' => 'jasminedelacruz@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 5,
                'device_type_id' => 4, // Tablet
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 5x Defective School Tablets (Parts & Salvage)',
                'condition' => 'non_functional',
                'description' => 'Bundle of 5 defective educational and budget Android tablets (Lenovo Tab M10, Samsung Tab A, Huawei MatePad). Cracked touchscreens and depleted lithium cells.',
                'estimated_weight' => 2.35,
                'carbon_footprint' => 5.41,
                'suggested_price' => 1100.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'image_filename' => null,
                'exact_date' => '2026-10-15 13:40:00',
            ],
            51 => [
                'seller_email' => 'sofiacastillo18@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 8,
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 8x Old Smartphones (Samsung & Xiaomi Lot)',
                'condition' => 'minor_damage',
                'description' => '8 units of older model Samsung Galaxy J-series and Xiaomi Redmi handsets. 5 units power on with cosmetic scratches and worn charging pins.',
                'estimated_weight' => 1.48,
                'carbon_footprint' => 3.40,
                'suggested_price' => 1350.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'image_filename' => null,
                'exact_date' => '2026-10-16 09:20:00',
            ],
            52 => [
                'seller_email' => 'carlofernandez07@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 15,
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 15x Depleted & Broken Smartphones Scrap Bundle',
                'condition' => 'non_functional',
                'description' => 'Scrap bundle of 15 broken mobile devices collected across barangays. Non-powering logic boards, cracked glass, and scrap chassis. Sorted for precious metals recovery.',
                'estimated_weight' => 2.70,
                'carbon_footprint' => 6.21,
                'suggested_price' => 900.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'image_filename' => null,
                'exact_date' => '2026-10-17 11:50:00',
            ],
            53 => [
                'seller_email' => 'patriciatorres21@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 6,
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 6x Mixed Tablets & Smartphones (E-Waste Recycler Lot)',
                'condition' => 'minor_damage',
                'description' => 'Assorted lot containing 3 Android smartphones and 3 8-inch Android tablets. 4 devices boot to setup screen with touch latency; 2 units have broken digitizers.',
                'estimated_weight' => 1.95,
                'carbon_footprint' => 4.49,
                'suggested_price' => 1650.00,
                'intended_action' => 'sell',
                'handover_preference' => 'both',
                'image_filename' => null,
                'exact_date' => '2026-10-17 15:30:00',
            ],
            54 => [
                'seller_email' => 'danielvillanueva13@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 4,
                'device_type_id' => 4, // Tablet
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 4x Apple iPad Tablets for Scrap & Refurbishing',
                'condition' => 'minor_damage',
                'description' => '4 older generation Apple iPad units (iPad Air and iPad Mini). Housing scuffs, 2 with cracked front glass, 2 with degraded batteries. Unlocked from iCloud.',
                'estimated_weight' => 1.80,
                'carbon_footprint' => 4.14,
                'suggested_price' => 2200.00,
                'intended_action' => 'sell',
                'handover_preference' => 'meetup_only',
                'image_filename' => null,
                'exact_date' => '2026-10-18 10:10:00',
            ],
            55 => [
                'seller_email' => 'nicolemendoza16@gmail.com',
                'listing_type' => 'bulk_lot',
                'lot_item_count' => 12,
                'device_type_id' => 3, // Smartphone
                'device_brand_id' => null,
                'device_model_id' => null,
                'device_details' => 'Bulk Lot: 12x Broken Touchscreen Phones (Salvage PCB Lot)',
                'condition' => 'non_functional',
                'description' => '12 dead smartphones with damaged motherboards, water intrusion, or shattered displays. Sorted and pre-segregated for circuit board recycling and tantalum capacitor salvage.',
                'estimated_weight' => 2.25,
                'carbon_footprint' => 5.18,
                'suggested_price' => 800.00,
                'intended_action' => 'sell',
                'handover_preference' => 'pickup_only',
                'image_filename' => null,
                'exact_date' => '2026-10-18 14:45:00',
            ],
        ];

        // 2. Insert or Update Listings
        $createdListings = [];

        foreach ($productsData as $prodIndex => $p) {
            $seller = User::where('email', $p['seller_email'])->first();
            if (!$seller) {
                continue;
            }

            // Calculate timestamp strictly after seller's creation, bounded to Oct 14 - 18, 2026
            $sellerCreated = Carbon::parse($seller->created_at ?? '2026-10-14 19:26:32');
            if ($sellerCreated->lt(Carbon::create(2026, 10, 14, 8, 0, 0))) {
                $sellerCreated = Carbon::create(2026, 10, 14, 9, 30, 0);
            } elseif ($sellerCreated->gt(Carbon::create(2026, 10, 18, 21, 0, 0))) {
                $sellerCreated = Carbon::create(2026, 10, 18, 16, 45, 0);
            }

            if (!empty($p['exact_date'])) {
                $createdStr = $p['exact_date'];
            } else {
                $listingCreated = (clone $sellerCreated)->addMinutes($p['minutes_after_user'] ?? 30);
                if ($listingCreated->hour >= 22) {
                    $listingCreated = (clone $sellerCreated)->subMinutes(10);
                }
                $createdStr = $listingCreated->toDateTimeString();
            }

            $listing = Listing::updateOrCreate(
                [
                    'user_id' => $seller->id,
                    'device_details' => $p['device_details'],
                ],
                [
                    'listing_type' => $p['listing_type'] ?? 'single',
                    'lot_item_count' => $p['lot_item_count'] ?? null,
                    'device_type_id' => $p['device_type_id'],
                    'device_brand_id' => $p['device_brand_id'] ?? null,
                    'device_model_id' => $p['device_model_id'] ?? null,
                    'condition' => $p['condition'],
                    'description' => $p['description'],
                    'estimated_weight' => $p['estimated_weight'],
                    'carbon_footprint' => $p['carbon_footprint'],
                    'suggested_price' => $p['suggested_price'],
                    'intended_action' => $p['intended_action'],
                    'handover_preference' => $p['handover_preference'] ?? 'pickup',
                    'pickup_address' => 'Brgy. ' . ($seller->barangay ?? 'San Carlos City') . ', San Carlos City, Pangasinan 2420',
                    'status' => 'available',
                ]
            );

            // Force timestamps in DB
            DB::table('listings')->where('id', $listing->id)->update([
                'created_at' => $createdStr,
                'updated_at' => $createdStr,
            ]);

            // Connect listing_photos row ONLY if image_filename is provided
            if (!empty($p['image_filename'])) {
                $photoUrl = '/storage/listings/' . $p['image_filename'];
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
                    'created_at' => $createdStr,
                    'updated_at' => $createdStr,
                ]);
            } else {
                // Products without images should have no photos in listing_photos
                DB::table('listing_photos')->where('listing_id', $listing->id)->delete();
            }

            // Log Product Creation in Audit Logs with simple name
            DB::table('audit_logs')->updateOrInsert(
                [
                    'user_id' => $seller->id,
                    'action' => 'listing_created',
                    'model_type' => 'Listing',
                    'model_id' => $listing->id,
                ],
                [
                    'description' => "User {$seller->name} posted new e-waste listing: {$p['device_details']} ({$p['condition']}) for {$p['intended_action']}",
                    'ip_address' => $seller->ip_address ?? '136.158.12.83',
                    'user_agent' => $seller->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0',
                    'created_at' => $createdStr,
                    'updated_at' => $createdStr,
                ]
            );

            $createdListings[$prodIndex] = $listing;
        }

        // 3. Transactions for Test Seller (seller@test.com) - Exactly 5 transactions from the 5 Buyers
        $transactions = [
            // Transaction 8: Jimmy Beltran -> Apple iPhone 13 Pro (Product 15) - Oct 13, 2026
            8 => [
                'product_index' => 15,
                'buyer_email' => 'jimmybeltran@gmail.com', // Jimmy Beltran
                'bid_amount' => 11800.00,
                'proposed_method' => 'repair',
                'notes' => 'Replacing hinge bracket assembly and deploying for student coding workstation.',
                'pickup_location' => 'Brgy. Mabini Plaza, San Carlos City',
                'status' => 'completed',
                'offer_time' => '2026-10-13 10:44:00',
                'accepted_time' => '2026-10-13 11:14:00',
                'pickup_time' => '2026-10-13 16:30:00',
                'completed_time' => '2026-10-13 16:45:00',
                'hours_after_listing' => 1.7,
                'hours_to_respond' => 0.5,
                'hours_to_pickup' => 5.2,
                'messages' => [
                    ['buyer', 'Good morning po Test Seller! Interesado po ako sa Apple iPhone 13 Pro. Original po ba ang charging cable nito?'],
                    ['seller', 'Magandang umaga po Jimmy! Opo, original Apple USB-C lightning cable ang kasama. 100% working cameras, Face ID, at OLED screen.'],
                    ['buyer', 'Sige po, nag-offer po ako ng ₱11,800. Pwede po ba meetup sa Mabini Plaza mamayang 3 PM?'],
                    ['seller', 'Deal po sir! See you po sa Mabini Plaza. Salamat po!'],
                ],
            ],

            // Transaction 9: Jerwin Lomibao -> Apple iPad 9th Gen (Product 16) - Oct 14, 2026
            9 => [
                'product_index' => 16,
                'buyer_email' => 'lomibaojerwin@gmail.com', // Jerwin Lomibao
                'bid_amount' => 3900.00,
                'proposed_method' => 'repair',
                'notes' => 'Refurbishing small form factor PC for barangay community desk digitization.',
                'pickup_location' => 'San Carlos City Public Market, San Carlos City',
                'status' => 'completed',
                'offer_time' => '2026-10-14 11:25:00',
                'accepted_time' => '2026-10-14 12:10:00',
                'pickup_time' => '2026-10-14 16:45:00',
                'completed_time' => '2026-10-14 17:00:00',
                'hours_after_listing' => 1.9,
                'hours_to_respond' => 0.8,
                'hours_to_pickup' => 4.5,
                'messages' => [
                    ['buyer', 'Hi seller, working po ba ang touchscreen at stereo speakers nitong iPad 9th Gen?'],
                    ['seller', 'Hello Jerwin! Yes po, tested and working ang Retina display, Touch ID, at battery health.'],
                    ['buyer', 'Ayos po! In-offeran ko po kayo ng ₱3,900. Pickup ko po mamaya.'],
                    ['seller', 'Accepted po sir Jerwin! Naka-pack na po with power adapter. Ingat po sa biyahe.'],
                ],
            ],

            // Transaction 10: Benigno Garcia -> Samsung Galaxy S22 (Product 17) - Oct 15, 2026
            10 => [
                'product_index' => 17,
                'buyer_email' => 'benignogarcia23@gmail.com', // Benigno Garcia
                'bid_amount' => 6000.00,
                'proposed_method' => 'repair',
                'notes' => 'Replacing back glass panel and battery calibration for personal daily driver.',
                'pickup_location' => 'Brgy. Mabini Barangay Hall, San Carlos City',
                'status' => 'completed',
                'offer_time' => '2026-10-15 13:40:00',
                'accepted_time' => '2026-10-15 14:20:00',
                'pickup_time' => '2026-10-15 17:15:00',
                'completed_time' => '2026-10-15 17:30:00',
                'hours_after_listing' => 4.1,
                'hours_to_respond' => 0.6,
                'hours_to_pickup' => 2.9,
                'messages' => [
                    ['buyer', 'Good day po! Working po ba 100% yung screen digitizer at cameras nitong S22?'],
                    ['seller', 'Good day Benigno! Opo, back glass lang may crack. Flawless ang AMOLED display and 120Hz refresh.'],
                    ['buyer', 'Sige po, kukunin ko for ₱6,000 para palitan ko na lang ng back housing.'],
                    ['seller', 'Deal po Sir Benigno, accepted na po ang offer ninyo. Salamat po!'],
                ],
            ],

            // Transaction 11: Kris Aquino -> iPad Pro 12.9" (Product 18) - Oct 16, 2026
            11 => [
                'product_index' => 18,
                'buyer_email' => 'krisaquino817@gmail.com', // Kris Aquino
                'bid_amount' => 8500.00,
                'proposed_method' => 'repair',
                'notes' => 'Testing Apple Pencil latency and graphic apps for art studio workstation.',
                'pickup_location' => 'San Carlos Town Plaza, San Carlos City',
                'status' => 'completed',
                'offer_time' => '2026-10-16 14:15:00',
                'accepted_time' => '2026-10-16 14:55:00',
                'pickup_time' => '2026-10-16 17:45:00',
                'completed_time' => '2026-10-16 18:00:00',
                'hours_after_listing' => 4.2,
                'hours_to_respond' => 0.7,
                'hours_to_pickup' => 2.8,
                'messages' => [
                    ['buyer', 'Hello po Test Seller! Clean iCloud and working po ba Apple Pencil compatibility nito?'],
                    ['seller', 'Yes Maam Kris! Signed out na po ang iCloud, factory reset, at tested sa Apple Pencil 2nd gen.'],
                    ['buyer', 'Great! Nag-submit po ako ng bid na ₱8,500 for inspection and pickup.'],
                    ['seller', 'Offer accepted po Maam Kris! Ihanda ko na po ang unit para sa ating pickup schedule.'],
                ],
            ],

            // Transaction 12: Abe Austria -> Samsung Galaxy Tab S6 Lite (Product 19) - Oct 13, 2026
            12 => [
                'product_index' => 19,
                'buyer_email' => 'Abeaustria@gmail.com', // Abe Austria
                'bid_amount' => 4500.00,
                'proposed_method' => 'harvest',
                'notes' => 'Harvesting UWQHD controller board and panel testing in e-waste repair lab.',
                'pickup_location' => 'Brgy. Mabini Crossing, San Carlos City',
                'status' => 'completed',
                'offer_time' => '2026-10-13 15:50:00',
                'accepted_time' => '2026-10-13 16:30:00',
                'pickup_time' => '2026-10-13 18:20:00',
                'completed_time' => '2026-10-13 18:35:00',
                'hours_after_listing' => 5.5,
                'hours_to_respond' => 0.7,
                'hours_to_pickup' => 1.8,
                'messages' => [
                    ['buyer', 'Sir available pa po itong Galaxy Tab S6 Lite? Kasama po ba ang charger at cable?'],
                    ['seller', 'Opo Sir Abe! Complete with original fast charger and Type-C cable.'],
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
            $offerCreated = $t['offer_time'] ?? (clone $listingTime)->addHours($t['hours_after_listing'])->toDateTimeString();
            $offerResponded = $t['accepted_time'] ?? (clone $listingTime)->addHours($t['hours_after_listing'] + $t['hours_to_respond'])->toDateTimeString();
            $pickupTime = $t['pickup_time'] ?? (clone $listingTime)->addHours($t['hours_after_listing'] + $t['hours_to_respond'] + $t['hours_to_pickup'])->toDateTimeString();

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

                $completionTime = $t['completed_time'] ?? Carbon::parse($pickupTime)->addMinutes(15)->toDateTimeString();
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
