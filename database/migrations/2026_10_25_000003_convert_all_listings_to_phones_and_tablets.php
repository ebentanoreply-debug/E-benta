<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Converts all marketplace listings to common e-waste (Smartphones & Tablets only).
     */
    public function up(): void
    {
        if (!Schema::hasTable('listings')) {
            return;
        }

        // 1. Get or create device_type_id for Smartphone and Tablet
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

        // 2. Specific conversion map for all known listing titles to common smartphones and tablets
        $conversionMap = [
            'broken' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Samsung Galaxy J2 Prime',
                'desc' => 'Old Samsung smartphone with cracked touch glass. Powers on, battery charges, ideal for parts harvesting or recycling.',
                'weight' => 0.16,
                'co2' => 0.37,
            ],
            'Lenovo ThinkPad X1' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Apple iPhone 11',
                'desc' => 'Liquid Retina display with hairline crack in corner. TrueDepth camera and Face ID working, battery health 79%.',
                'weight' => 0.19,
                'co2' => 0.44,
            ],
            'MacBook Pro 13"' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad Air',
                'desc' => '10.5-inch Retina display with minor corner scuffs. A12 Bionic chip, stereo speakers, good battery life.',
                'weight' => 0.46,
                'co2' => 1.06,
            ],
            'Dell OptiPlex PC' => [
                'type_id' => $tabletTypeId,
                'name' => 'Samsung Galaxy Tab A8',
                'desc' => '10.5-inch entertainment tablet with quad speakers. Battery tested healthy, clean firmware.',
                'weight' => 0.51,
                'co2' => 1.17,
            ],
            'HP LaserJet Pro' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Xiaomi Redmi Note 10',
                'desc' => 'AMOLED screen with minor glass crack. Quad camera and fast charging fully functional.',
                'weight' => 0.18,
                'co2' => 0.41,
            ],
            'LG UltraWide 34"' => [
                'type_id' => $tabletTypeId,
                'name' => 'Samsung Galaxy Tab S7',
                'desc' => '11-inch 120Hz display with S-Pen support. Scratched back panel, logic board responsive.',
                'weight' => 0.50,
                'co2' => 1.15,
            ],
            'ASUS VivoBook 15' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'OPPO Reno 4',
                'desc' => 'Slim Android phone with worn battery. 48MP camera, AMOLED screen, and fingerprint sensor intact.',
                'weight' => 0.17,
                'co2' => 0.39,
            ],
            'Dell UltraSharp 27"' => [
                'type_id' => $tabletTypeId,
                'name' => 'Huawei MatePad T10',
                'desc' => 'Compact 9.7-inch tablet for kids/students. Display has minor scuffs, Wi-Fi tested working.',
                'weight' => 0.45,
                'co2' => 1.04,
            ],
            'HP Pavilion Desktop' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Realme C25',
                'desc' => '6000mAh battery phone with worn charging port. Motherboard and LCD panel operational.',
                'weight' => 0.21,
                'co2' => 0.48,
            ],
            'Dell XPS 13' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Vivo Y20',
                'desc' => 'Triple macro camera phone. Minor body scratches, clean operating system, ideal for budget daily use.',
                'weight' => 0.19,
                'co2' => 0.44,
            ],
            'MacBook Air M1' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Apple iPhone 13 Pro',
                'desc' => 'Super Retina XDR OLED phone with minor bezel scuffs. ProMotion 120Hz, A15 Bionic, cameras tested 100%.',
                'weight' => 0.20,
                'co2' => 0.46,
            ],
            'Dell OptiPlex Micro' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad 9th Gen',
                'desc' => '10.2-inch Retina display tablet with A13 Bionic. Clean iCloud, Touch ID functional, includes charger.',
                'weight' => 0.49,
                'co2' => 1.13,
            ],
            'LG Curved Monitor 34"' => [
                'type_id' => $tabletTypeId,
                'name' => 'Samsung Galaxy Tab S6 Lite',
                'desc' => '10.4-inch tablet with AKG tuned sound. Hairline scratch on bezel, digitizer responsive.',
                'weight' => 0.47,
                'co2' => 1.08,
            ],
            'Acer Aspire 5' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Xiaomi Redmi 9A',
                'desc' => 'Entry-level budget smartphone with good 5000mAh battery. Minor glass scratches, fully unlocked.',
                'weight' => 0.19,
                'co2' => 0.44,
            ],
            'Canon PIXMA G3010' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Samsung Galaxy A12',
                'desc' => 'Quad camera phone with scuffed rear cover. Clean IMEI, speaker and mic operational.',
                'weight' => 0.20,
                'co2' => 0.46,
            ],
            'Logitech MX Master 3' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Realme 5 Pro',
                'desc' => 'Snapdragon 712 smartphone. Minor battery wear, 48MP AI quad camera, VOOC fast charging tested.',
                'weight' => 0.18,
                'co2' => 0.41,
            ],
            'TP-Link Archer AX50' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'OPPO F11 Pro',
                'desc' => 'Panoramic screen smartphone with pop-up selfie camera. Clean front glass, dual SIM unlocked.',
                'weight' => 0.19,
                'co2' => 0.44,
            ],
            'Sony PlayStation 4 Slim' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad 8th Gen',
                'desc' => 'A12 Bionic tablet with 10.2-inch display. Good battery health, supports Apple Pencil 1st Gen.',
                'weight' => 0.49,
                'co2' => 1.13,
            ],
            'Apple Magic Keyboard' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Huawei Nova 7i',
                'desc' => 'Kirin 810 smartphone with punch-hole display. Tested 40W SuperCharge and quad camera modules.',
                'weight' => 0.18,
                'co2' => 0.41,
            ],
            'Dell Inspiron 15' => [
                'type_id' => $tabletTypeId,
                'name' => 'Samsung Galaxy Tab A7 Lite',
                'desc' => 'Compact 8.7-inch portable tablet. Slim metal cover, Dolby Atmos sound, clean Android 12.',
                'weight' => 0.37,
                'co2' => 0.85,
            ],
            'HP DeskJet 2330' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Infinix Hot 10',
                'desc' => 'Helio G70 gaming phone with 6.78-inch HD+ display. Minor back scuffs, 5200mAh battery intact.',
                'weight' => 0.20,
                'co2' => 0.46,
            ],
            'Netgear Nighthawk AC1900' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Vivo V20',
                'desc' => '44MP eye-autofocus selfie phone with matte glass design. Battery and AMOLED display operational.',
                'weight' => 0.17,
                'co2' => 0.39,
            ],
            'ASUS ProArt Display' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad Mini 5',
                'desc' => '7.9-inch Retina display with True Tone. Compact aluminum body, A12 Bionic, fast Wi-Fi.',
                'weight' => 0.30,
                'co2' => 0.69,
            ],
            'Mechanical Gaming Keyboard' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Xiaomi Poco X3 Pro',
                'desc' => 'Snapdragon 860 phone with 120Hz display. Cracked camera protector, fast gaming performance.',
                'weight' => 0.21,
                'co2' => 0.48,
            ],
            'Apple Magic Mouse 2' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Samsung Galaxy J7 Prime',
                'desc' => 'Classic full metal unibody smartphone. Front fingerprint scanner and LCD screen responsive.',
                'weight' => 0.17,
                'co2' => 0.39,
            ],
            'Lenovo IdeaPad 3' => [
                'type_id' => $tabletTypeId,
                'name' => 'Lenovo Tab M10',
                'desc' => '10.1-inch HD family tablet with dual front speakers. Charging port operational, clean casing.',
                'weight' => 0.48,
                'co2' => 1.10,
            ],
            'iMac 27" Core i5' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad Pro 11"',
                'desc' => 'Liquid Retina display with ProMotion 120Hz. Quad speakers, Face ID working, clean iCloud.',
                'weight' => 0.47,
                'co2' => 1.08,
            ],
            'Samsung 24" Curved Monitor' => [
                'type_id' => $tabletTypeId,
                'name' => 'Amazon Fire HD 10',
                'desc' => '10.1-inch 1080p Full HD entertainment tablet. Dual stereo speakers, good battery life.',
                'weight' => 0.46,
                'co2' => 1.06,
            ],
            'Acer Swift 3 Ultra-Thin' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Apple iPhone XR',
                'desc' => 'Liquid Retina HD display with A12 Bionic. Wireless charging, Face ID, and audio working 100%.',
                'weight' => 0.19,
                'co2' => 0.44,
            ],
            'TP-Link Deco Mesh Wi-Fi' => [
                'type_id' => $tabletTypeId,
                'name' => 'Huawei MediaPad M5 Lite',
                'desc' => 'Harmon Kardon quad speakers with 10.1-inch screen. Great for e-reading and student video review.',
                'weight' => 0.47,
                'co2' => 1.08,
            ],
            'Canon PIXMA TS207' => [
                'type_id' => $tabletTypeId,
                'name' => 'Realme Pad',
                'desc' => '10.4-inch 2K display tablet with ultra-slim 6.9mm body. Hi-Res audio quad speakers working.',
                'weight' => 0.44,
                'co2' => 1.01,
            ],
            'Logitech K380 Multi-Device' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Apple iPhone 8 Plus',
                'desc' => 'Dual 12MP cameras with portrait mode. Touch ID responsive, clean back glass, battery health 80%.',
                'weight' => 0.20,
                'co2' => 0.46,
            ],
            'Logitech G304 Lightspeed' => [
                'type_id' => $smartphoneTypeId,
                'name' => 'Samsung Galaxy Note 10',
                'desc' => 'Dynamic AMOLED Infinity-O display with S-Pen. Minor curved glass wear, wireless PowerShare intact.',
                'weight' => 0.17,
                'co2' => 0.39,
            ],
            'Dell 24" P2419H IPS Monitor' => [
                'type_id' => $tabletTypeId,
                'name' => 'Xiaomi Pad 5',
                'desc' => '11-inch WQHD+ 120Hz display with Snapdragon 860. Dolby Atmos quad speakers, clean casing.',
                'weight' => 0.51,
                'co2' => 1.17,
            ],
            'Copper Cable & Power Cord Bundle' => [
                'type_id' => $tabletTypeId,
                'name' => 'Apple iPad Mini 4',
                'desc' => 'Ultra-compact 7.9-inch tablet. Minor battery aging, Touch ID and Retina display functional.',
                'weight' => 0.30,
                'co2' => 0.69,
            ],
            'HP LaserJet 1020 Plus' => [
                'type_id' => $tabletTypeId,
                'name' => 'Lenovo Yoga Smart Tab',
                'desc' => 'Innovative kickstand tablet with JBL stereo speakers and ambient Google Assistant display mode.',
                'weight' => 0.58,
                'co2' => 1.33,
            ],
            'Lenovo ThinkCentre Tiny PC' => [
                'type_id' => $tabletTypeId,
                'name' => 'Samsung Galaxy Tab S5e',
                'desc' => 'Super AMOLED 10.5-inch tablet weighing only 400g. AKG quad speakers and biometric reader tested.',
                'weight' => 0.40,
                'co2' => 0.92,
            ],
        ];

        // 3. Apply the specific conversions
        foreach ($conversionMap as $oldTitle => $data) {
            DB::table('listings')->where('device_details', $oldTitle)->update([
                'device_type_id' => $data['type_id'],
                'device_details' => $data['name'],
                'description' => $data['desc'],
                'estimated_weight' => $data['weight'],
                'carbon_footprint' => $data['co2'],
            ]);

            // Update linked audit logs
            if (Schema::hasTable('audit_logs')) {
                $logs = DB::table('audit_logs')
                    ->where('description', 'like', "%{$oldTitle}%")
                    ->get();
                foreach ($logs as $log) {
                    $newDesc = str_replace($oldTitle, $data['name'], $log->description);
                    DB::table('audit_logs')->where('id', $log->id)->update(['description' => $newDesc]);
                }
            }
        }

        // 4. Update any remaining non-smartphone / non-tablet listings
        $commonFallbacks = [
            ['type_id' => $smartphoneTypeId, 'name' => 'Samsung Galaxy A03', 'desc' => '6.5-inch HD+ phone with 48MP dual camera and 5000mAh battery. Minor scuffs on rear cover.', 'weight' => 0.20, 'co2' => 0.46],
            ['type_id' => $tabletTypeId, 'name' => 'Huawei MatePad SE', 'desc' => '10.4-inch 2K eye-comfort display tablet. Surround sound speakers, clean firmware.', 'weight' => 0.44, 'co2' => 1.01],
            ['type_id' => $smartphoneTypeId, 'name' => 'Realme C11', 'desc' => 'Big battery smartphone with geometric art design. Functional touchscreen and camera.', 'weight' => 0.19, 'co2' => 0.44],
            ['type_id' => $tabletTypeId, 'name' => 'Apple iPad 6th Gen', 'desc' => '9.7-inch Retina display tablet with A10 Fusion. Touch ID and stereo speakers operational.', 'weight' => 0.47, 'co2' => 1.08],
            ['type_id' => $smartphoneTypeId, 'name' => 'Vivo Y11', 'desc' => 'AI dual camera phone with 5000mAh battery. Minor frame scratches, responsive system.', 'weight' => 0.19, 'co2' => 0.44],
            ['type_id' => $tabletTypeId, 'name' => 'Samsung Galaxy Tab A 8.0', 'desc' => 'Compact 8-inch screen tablet. Lightweight metal frame, dual speakers, good battery.', 'weight' => 0.35, 'co2' => 0.81],
        ];

        $otherListings = DB::table('listings')
            ->whereNotIn('device_type_id', [$smartphoneTypeId, $tabletTypeId])
            ->get();

        foreach ($otherListings as $i => $item) {
            $pick = $commonFallbacks[$i % count($commonFallbacks)];
            DB::table('listings')->where('id', $item->id)->update([
                'device_type_id' => $pick['type_id'],
                'device_details' => $pick['name'],
                'description' => $pick['desc'],
                'estimated_weight' => $pick['weight'],
                'carbon_footprint' => $pick['co2'],
            ]);

            if (Schema::hasTable('audit_logs')) {
                $logs = DB::table('audit_logs')
                    ->where('model_type', 'Listing')
                    ->where('model_id', $item->id)
                    ->get();
                foreach ($logs as $log) {
                    $newDesc = preg_replace('/listing: [^(\n]+/', "listing: {$pick['name']} ", $log->description);
                    DB::table('audit_logs')->where('id', $log->id)->update(['description' => $newDesc]);
                }
            }
        }

        // 5. Update transaction chat messages in messages table for phone/tablet authenticity
        if (Schema::hasTable('messages')) {
            $msgUpdates = [
                'MacBook Air M1' => 'iPhone 13 Pro',
                'Dell OptiPlex Micro' => 'iPad 9th Gen',
                'LG UltraWide' => 'iPad Air',
            ];
            foreach ($msgUpdates as $search => $replace) {
                $messages = DB::table('messages')->where('message', 'like', "%{$search}%")->get();
                foreach ($messages as $msg) {
                    $newMsg = str_replace($search, $replace, $msg->message);
                    DB::table('messages')->where('id', $msg->id)->update(['message' => $newMsg]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversible if needed
    }
};
