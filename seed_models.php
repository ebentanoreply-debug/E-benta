<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Insert Device Models
// Device Types: 19=Laptop, 20=Desktop, 21=Smartphone, 22=Tablet, 23=Monitor, 24=Keyboard, 25=Mouse, 26=Printer, 27=Router
// Device Brands: 11=Apple, 12=Dell, 13=HP, 14=Lenovo, 15=ASUS, 16=Samsung, 17=LG, 18=Sony, 19=Acer, 20=Intel
$models = [
    ['device_type_id' => 19, 'device_brand_id' => 11, 'model_name' => 'MacBook Pro 13"'],
    ['device_type_id' => 19, 'device_brand_id' => 11, 'model_name' => 'MacBook Air M1'],
    ['device_type_id' => 19, 'device_brand_id' => 12, 'model_name' => 'Dell XPS 13'],
    ['device_type_id' => 19, 'device_brand_id' => 13, 'model_name' => 'HP Pavilion 15'],
    ['device_type_id' => 19, 'device_brand_id' => 14, 'model_name' => 'Lenovo ThinkPad X1'],
    ['device_type_id' => 19, 'device_brand_id' => 15, 'model_name' => 'ASUS VivoBook 15'],
    ['device_type_id' => 20, 'device_brand_id' => 11, 'model_name' => 'iMac 27"'],
    ['device_type_id' => 20, 'device_brand_id' => 12, 'model_name' => 'Dell OptiPlex'],
    ['device_type_id' => 20, 'device_brand_id' => 13, 'model_name' => 'HP Pavilion Desktop'],
    ['device_type_id' => 21, 'device_brand_id' => 11, 'model_name' => 'iPhone 13'],
    ['device_type_id' => 21, 'device_brand_id' => 11, 'model_name' => 'iPhone 12'],
    ['device_type_id' => 21, 'device_brand_id' => 16, 'model_name' => 'Samsung Galaxy S21'],
    ['device_type_id' => 21, 'device_brand_id' => 16, 'model_name' => 'Samsung Galaxy S22'],
    ['device_type_id' => 22, 'device_brand_id' => 11, 'model_name' => 'iPad Pro 12.9"'],
    ['device_type_id' => 22, 'device_brand_id' => 11, 'model_name' => 'iPad Air'],
    ['device_type_id' => 22, 'device_brand_id' => 16, 'model_name' => 'Samsung Galaxy Tab S7'],
    ['device_type_id' => 23, 'device_brand_id' => 12, 'model_name' => 'Dell U2720Q 27"'],
    ['device_type_id' => 23, 'device_brand_id' => 17, 'model_name' => 'LG UltraWide 34"'],
    ['device_type_id' => 23, 'device_brand_id' => 15, 'model_name' => 'ASUS ProArt 32"'],
    ['device_type_id' => 24, 'device_brand_id' => 15, 'model_name' => 'Mechanical RGB Keyboard'],
    ['device_type_id' => 24, 'device_brand_id' => 11, 'model_name' => 'Apple Magic Keyboard'],
    ['device_type_id' => 25, 'device_brand_id' => 19, 'model_name' => 'Logitech MX Master 3'],
    ['device_type_id' => 25, 'device_brand_id' => 11, 'model_name' => 'Apple Magic Mouse'],
    ['device_type_id' => 26, 'device_brand_id' => 13, 'model_name' => 'HP LaserJet Pro'],
    ['device_type_id' => 26, 'device_brand_id' => 20, 'model_name' => 'Canon PIXMA'],
    ['device_type_id' => 27, 'device_brand_id' => 20, 'model_name' => 'TP-Link WiFi 6 Router'],
    ['device_type_id' => 27, 'device_brand_id' => 20, 'model_name' => 'Netgear Nighthawk'],
];

foreach ($models as $model) {
    DB::table('device_models')->insert([
        'device_type_id' => $model['device_type_id'],
        'device_brand_id' => $model['device_brand_id'],
        'model_name' => $model['model_name'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

echo "\n✓ " . count($models) . " device models inserted successfully!\n\n";
?>
