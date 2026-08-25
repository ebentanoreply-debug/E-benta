<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        // Device Types
        $deviceTypes = [
            ['name' => 'Laptop', 'icon' => 'fa-laptop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desktop Computer', 'icon' => 'fa-desktop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Smartphone', 'icon' => 'fa-mobile-alt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tablet', 'icon' => 'fa-tablet-alt', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Monitor', 'icon' => 'fa-tv', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Keyboard', 'icon' => 'fa-keyboard', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mouse', 'icon' => 'fa-mouse', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Printer', 'icon' => 'fa-print', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Router', 'icon' => 'fa-wifi', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('device_types')->insert($deviceTypes);

        // Device Brands
        $deviceBrands = [
            ['name' => 'Apple', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dell', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lenovo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ASUS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sony', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Acer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intel', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('device_brands')->insert($deviceBrands);

        // Device Models (with device_type_id and device_brand_id)
        $deviceModels = [
            // Laptops (type_id = 1)
            ['device_type_id' => 1, 'device_brand_id' => 1, 'model_name' => 'MacBook Pro 13"', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 1, 'device_brand_id' => 1, 'model_name' => 'MacBook Air M1', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 1, 'device_brand_id' => 2, 'model_name' => 'Dell XPS 13', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 1, 'device_brand_id' => 3, 'model_name' => 'HP Pavilion 15', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 1, 'device_brand_id' => 4, 'model_name' => 'Lenovo ThinkPad X1', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 1, 'device_brand_id' => 5, 'model_name' => 'ASUS VivoBook 15', 'created_at' => now(), 'updated_at' => now()],

            // Desktop Computers (type_id = 2)
            ['device_type_id' => 2, 'device_brand_id' => 1, 'model_name' => 'iMac 27"', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 2, 'device_brand_id' => 2, 'model_name' => 'Dell OptiPlex', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 2, 'device_brand_id' => 3, 'model_name' => 'HP Pavilion Desktop', 'created_at' => now(), 'updated_at' => now()],

            // Smartphones (type_id = 3)
            ['device_type_id' => 3, 'device_brand_id' => 1, 'model_name' => 'iPhone 13', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 3, 'device_brand_id' => 1, 'model_name' => 'iPhone 12', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 3, 'device_brand_id' => 6, 'model_name' => 'Samsung Galaxy S21', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 3, 'device_brand_id' => 6, 'model_name' => 'Samsung Galaxy S22', 'created_at' => now(), 'updated_at' => now()],

            ['device_type_id' => 4, 'device_brand_id' => 1, 'model_name' => 'iPad Pro 12.9"', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 4, 'device_brand_id' => 1, 'model_name' => 'iPad Air', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 4, 'device_brand_id' => 6, 'model_name' => 'Samsung Galaxy Tab S7', 'created_at' => now(), 'updated_at' => now()],

            // Monitors (type_id = 5)
            ['device_type_id' => 5, 'device_brand_id' => 2, 'model_name' => 'Dell U2720Q 27"', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 5, 'device_brand_id' => 7, 'model_name' => 'LG UltraWide 34"', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 5, 'device_brand_id' => 5, 'model_name' => 'ASUS ProArt 32"', 'created_at' => now(), 'updated_at' => now()],

            // Keyboards (type_id = 6)
            ['device_type_id' => 6, 'device_brand_id' => 5, 'model_name' => 'Mechanical RGB Keyboard', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 6, 'device_brand_id' => 1, 'model_name' => 'Apple Magic Keyboard', 'created_at' => now(), 'updated_at' => now()],

            // Mouse (type_id = 7)
            ['device_type_id' => 7, 'device_brand_id' => 9, 'model_name' => 'Logitech MX Master 3', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 7, 'device_brand_id' => 1, 'model_name' => 'Apple Magic Mouse', 'created_at' => now(), 'updated_at' => now()],

            // Printers (type_id = 8)
            ['device_type_id' => 8, 'device_brand_id' => 3, 'model_name' => 'HP LaserJet Pro', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 8, 'device_brand_id' => 10, 'model_name' => 'Canon PIXMA', 'created_at' => now(), 'updated_at' => now()],

            // Routers (type_id = 9)
            ['device_type_id' => 9, 'device_brand_id' => 9, 'model_name' => 'TP-Link WiFi 6 Router', 'created_at' => now(), 'updated_at' => now()],
            ['device_type_id' => 9, 'device_brand_id' => 10, 'model_name' => 'Netgear Nighthawk', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('device_models')->insert($deviceModels);
    }
}
