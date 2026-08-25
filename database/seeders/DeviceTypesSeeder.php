<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use App\Models\DeviceBrand;
use App\Models\DeviceModel;
use Illuminate\Database\Seeder;

class DeviceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Device Types
        $laptop = DeviceType::create([
            'name' => 'Laptop',
            'description' => 'Portable computers for work and personal use',
            'icon' => 'fa-laptop',
        ]);

        $smartphone = DeviceType::create([
            'name' => 'Smartphone',
            'description' => 'Mobile phones with computing capabilities',
            'icon' => 'fa-mobile-alt',
        ]);

        $tablet = DeviceType::create([
            'name' => 'Tablet',
            'description' => 'Portable touchscreen devices',
            'icon' => 'fa-tablet',
        ]);

        $desktop = DeviceType::create([
            'name' => 'Desktop',
            'description' => 'Stationary computing devices',
            'icon' => 'fa-desktop',
        ]);

        $monitor = DeviceType::create([
            'name' => 'Monitor',
            'description' => 'Display screens for computers',
            'icon' => 'fa-tv',
        ]);

        // Create Brands
        $apple = DeviceBrand::create([
            'name' => 'Apple',
            'description' => 'Premium devices and technology',
        ]);

        $samsung = DeviceBrand::create([
            'name' => 'Samsung',
            'description' => 'Electronics and mobile devices',
        ]);

        $dell = DeviceBrand::create([
            'name' => 'Dell',
            'description' => 'Computer hardware and technology',
        ]);

        $hp = DeviceBrand::create([
            'name' => 'HP',
            'description' => 'Technology and printing solutions',
        ]);

        $lenovo = DeviceBrand::create([
            'name' => 'Lenovo',
            'description' => 'Computing devices and solutions',
        ]);

        // Create Device Models
        DeviceModel::create([
            'device_type_id' => $laptop->id,
            'device_brand_id' => $apple->id,
            'model_name' => 'MacBook Pro 13"',
            'description' => 'Apple MacBook Pro 13-inch',
        ]);

        DeviceModel::create([
            'device_type_id' => $laptop->id,
            'device_brand_id' => $apple->id,
            'model_name' => 'MacBook Air M1',
            'description' => 'Apple MacBook Air with M1 chip',
        ]);

        DeviceModel::create([
            'device_type_id' => $laptop->id,
            'device_brand_id' => $dell->id,
            'model_name' => 'Dell XPS 13',
            'description' => 'Dell XPS 13-inch ultrabook',
        ]);

        DeviceModel::create([
            'device_type_id' => $smartphone->id,
            'device_brand_id' => $apple->id,
            'model_name' => 'iPhone 13',
            'description' => 'Apple iPhone 13',
        ]);

        DeviceModel::create([
            'device_type_id' => $smartphone->id,
            'device_brand_id' => $samsung->id,
            'model_name' => 'Galaxy S21',
            'description' => 'Samsung Galaxy S21',
        ]);

        DeviceModel::create([
            'device_type_id' => $tablet->id,
            'device_brand_id' => $apple->id,
            'model_name' => 'iPad Pro 12.9"',
            'description' => 'Apple iPad Pro 12.9-inch',
        ]);

        DeviceModel::create([
            'device_type_id' => $tablet->id,
            'device_brand_id' => $samsung->id,
            'model_name' => 'Galaxy Tab S7',
            'description' => 'Samsung Galaxy Tab S7',
        ]);

        DeviceModel::create([
            'device_type_id' => $desktop->id,
            'device_brand_id' => $hp->id,
            'model_name' => 'HP Pavilion Desktop',
            'description' => 'HP Pavilion Desktop Computer',
        ]);

        DeviceModel::create([
            'device_type_id' => $monitor->id,
            'device_brand_id' => $dell->id,
            'model_name' => 'Dell UltraSharp U2720Q',
            'description' => '27" 4K USB-C Monitor',
        ]);
    }
}
