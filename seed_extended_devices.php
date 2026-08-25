<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Adding More Device Types, Brands, and Models ===\n\n";

// Additional Device Types
$newDeviceTypes = [
    ['name' => 'Headphones', 'icon' => 'fa-headphones', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'External Hard Drive', 'icon' => 'fa-hdd', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'USB Flash Drive', 'icon' => 'fa-memory', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Charger & Cable', 'icon' => 'fa-plug', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Monitor Stand', 'icon' => 'fa-rectangle-landscape', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Laptop Stand', 'icon' => 'fa-laptop', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Phone Case/Screen Protector', 'icon' => 'fa-shield', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Speaker', 'icon' => 'fa-volume-up', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Webcam', 'icon' => 'fa-camera', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Docking Station', 'icon' => 'fa-network-wired', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Smartwatch', 'icon' => 'fa-watch', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Gaming Console', 'icon' => 'fa-gamepad', 'created_at' => now(), 'updated_at' => now()],
];

echo "Adding " . count($newDeviceTypes) . " new device types...\n";
foreach ($newDeviceTypes as $type) {
    DB::table('device_types')->insertOrIgnore($type);
}

// Additional Device Brands
$newDeviceBrands = [
    ['name' => 'Google', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Microsoft', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'OnePlus', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Xiaomi', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'HTC', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Nokia', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Huawei', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Razer', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Corsair', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Logitech', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'JBL', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Beats', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Bose', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Western Digital', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Seagate', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Kingston', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Sandisk', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Canon', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'TP-Link', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Netgear', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Motorola', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'OPPO', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Vivo', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Realme', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Nothing', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Nintendo', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Sony', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Sennheiser', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Garmin', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Fitbit', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Brother', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'BenQ', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Anker', 'created_at' => now(), 'updated_at' => now()],
];

echo "Adding " . count($newDeviceBrands) . " new device brands...\n";
foreach ($newDeviceBrands as $brand) {
    DB::table('device_brands')->insertOrIgnore($brand);
}

// Get IDs for all device types and brands
$allTypes = DB::table('device_types')->pluck('id', 'name')->toArray();
$allBrands = DB::table('device_brands')->pluck('id', 'name')->toArray();

// Comprehensive Device Models
$comprehensiveModels = [
    // Existing Laptops (expanded)
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'MacBook Pro 16"', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'MacBook Pro 14"', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Dell'], 'model_name' => 'Dell Inspiron 15', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['HP'], 'model_name' => 'HP Envy 13', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Lenovo'], 'model_name' => 'Lenovo IdeaPad 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['ASUS'], 'model_name' => 'ASUS TUF Gaming', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Acer'], 'model_name' => 'Acer Aspire 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Microsoft'], 'model_name' => 'Surface Laptop 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Laptop'], 'device_brand_id' => $allBrands['Razer'], 'model_name' => 'Razer Blade 15', 'created_at' => now(), 'updated_at' => now()],

    // Desktop Computers (expanded)
    ['device_type_id' => $allTypes['Desktop Computer'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'Mac Mini', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Desktop Computer'], 'device_brand_id' => $allBrands['Dell'], 'model_name' => 'Dell Inspiron Desktop', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Desktop Computer'], 'device_brand_id' => $allBrands['HP'], 'model_name' => 'HP Pavilion 25L', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Desktop Computer'], 'device_brand_id' => $allBrands['Lenovo'], 'model_name' => 'Lenovo IdeaCentre', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Desktop Computer'], 'device_brand_id' => $allBrands['ASUS'], 'model_name' => 'ASUS ROG Strix', 'created_at' => now(), 'updated_at' => now()],

    // Smartphones (expanded)
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'iPhone 14 Pro', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'iPhone 14', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'iPhone SE 3rd Gen', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung Galaxy A52', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung Galaxy Note 20', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Google'], 'model_name' => 'Google Pixel 7', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Google'], 'model_name' => 'Google Pixel 6a', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['OnePlus'], 'model_name' => 'OnePlus 10 Pro', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Xiaomi'], 'model_name' => 'Xiaomi 12', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartphone'], 'device_brand_id' => $allBrands['Motorola'], 'model_name' => 'Motorola Moto G32', 'created_at' => now(), 'updated_at' => now()],

    // Tablets (expanded)
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'iPad Mini 6th Gen', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'iPad 10th Gen', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung Galaxy Tab S8', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung Galaxy Tab A8', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Microsoft'], 'model_name' => 'Surface Go 3', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Tablet'], 'device_brand_id' => $allBrands['Lenovo'], 'model_name' => 'Lenovo Tab M10', 'created_at' => now(), 'updated_at' => now()],

    // Monitors (expanded)
    ['device_type_id' => $allTypes['Monitor'], 'device_brand_id' => $allBrands['Dell'], 'model_name' => 'Dell P2423DE 24"', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Monitor'], 'device_brand_id' => $allBrands['LG'], 'model_name' => 'LG 27GP850 27"', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Monitor'], 'device_brand_id' => $allBrands['ASUS'], 'model_name' => 'ASUS PA279CV 27"', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Monitor'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung M7 Smart Monitor', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Monitor'], 'device_brand_id' => $allBrands['BenQ'], 'model_name' => 'BenQ PD2500Q 25"', 'created_at' => now(), 'updated_at' => now()],

    // Keyboards (expanded)
    ['device_type_id' => $allTypes['Keyboard'], 'device_brand_id' => $allBrands['Corsair'], 'model_name' => 'Corsair K95 Platinum XT', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Keyboard'], 'device_brand_id' => $allBrands['Logitech'], 'model_name' => 'Logitech G Pro X', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Keyboard'], 'device_brand_id' => $allBrands['Razer'], 'model_name' => 'Razer DeathStalker V2', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Keyboard'], 'device_brand_id' => $allBrands['Microsoft'], 'model_name' => 'Microsoft Sculpt Ergonomic', 'created_at' => now(), 'updated_at' => now()],

    // Mouse (expanded)
    ['device_type_id' => $allTypes['Mouse'], 'device_brand_id' => $allBrands['Logitech'], 'model_name' => 'Logitech G502 Hero', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Mouse'], 'device_brand_id' => $allBrands['Razer'], 'model_name' => 'Razer DeathAdder V3', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Mouse'], 'device_brand_id' => $allBrands['Corsair'], 'model_name' => 'Corsair M65 RGB Elite', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Mouse'], 'device_brand_id' => $allBrands['Microsoft'], 'model_name' => 'Microsoft Sculpt Comfort Mouse', 'created_at' => now(), 'updated_at' => now()],

    // Printers
    ['device_type_id' => $allTypes['Printer'], 'device_brand_id' => $allBrands['HP'], 'model_name' => 'HP OfficeJet Pro', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Printer'], 'device_brand_id' => $allBrands['Canon'], 'model_name' => 'Canon imageCLASS', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Printer'], 'device_brand_id' => $allBrands['Brother'], 'model_name' => 'Brother HL-L8360CDW', 'created_at' => now(), 'updated_at' => now()],

    // Routers
    ['device_type_id' => $allTypes['Router'], 'device_brand_id' => $allBrands['TP-Link'], 'model_name' => 'TP-Link Archer AX6000', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Router'], 'device_brand_id' => $allBrands['Netgear'], 'model_name' => 'Netgear RAXE300', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Router'], 'device_brand_id' => $allBrands['ASUS'], 'model_name' => 'ASUS ROG Rapture GT-AX11000', 'created_at' => now(), 'updated_at' => now()],

    // Headphones
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'AirPods Pro 2', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'AirPods Max', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Sony'], 'model_name' => 'Sony WH-1000XM5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Beats'], 'model_name' => 'Beats Studio Pro', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Bose'], 'model_name' => 'Bose QuietComfort 45', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['JBL'], 'model_name' => 'JBL Live 650 BTNC', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Headphones'], 'device_brand_id' => $allBrands['Sennheiser'], 'model_name' => 'Sennheiser MOMENTUM 4', 'created_at' => now(), 'updated_at' => now()],

    // External Hard Drive
    ['device_type_id' => $allTypes['External Hard Drive'], 'device_brand_id' => $allBrands['Western Digital'], 'model_name' => 'WD My Passport 4TB', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['External Hard Drive'], 'device_brand_id' => $allBrands['Western Digital'], 'model_name' => 'WD Elements 2TB', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['External Hard Drive'], 'device_brand_id' => $allBrands['Seagate'], 'model_name' => 'Seagate Backup Plus 5TB', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['External Hard Drive'], 'device_brand_id' => $allBrands['Seagate'], 'model_name' => 'Seagate One Touch 2TB', 'created_at' => now(), 'updated_at' => now()],

    // USB Flash Drive
    ['device_type_id' => $allTypes['USB Flash Drive'], 'device_brand_id' => $allBrands['Kingston'], 'model_name' => 'Kingston DataTraveler Kyson 64GB', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['USB Flash Drive'], 'device_brand_id' => $allBrands['Sandisk'], 'model_name' => 'SanDisk Ultra 3D 32GB', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['USB Flash Drive'], 'device_brand_id' => $allBrands['Kingston'], 'model_name' => 'Kingston A2000 1TB', 'created_at' => now(), 'updated_at' => now()],

    // Charger & Cable
    ['device_type_id' => $allTypes['Charger & Cable'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'Apple USB-C Power Adapter 96W', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Charger & Cable'], 'device_brand_id' => $allBrands['Corsair'], 'model_name' => 'Corsair RM1000x 1000W PSU', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Charger & Cable'], 'device_brand_id' => $allBrands['Anker'], 'model_name' => 'Anker 65W USB-C Charger', 'created_at' => now(), 'updated_at' => now()],

    // Speaker
    ['device_type_id' => $allTypes['Speaker'], 'device_brand_id' => $allBrands['JBL'], 'model_name' => 'JBL Charge 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Speaker'], 'device_brand_id' => $allBrands['Sony'], 'model_name' => 'Sony SRS-XB43', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Speaker'], 'device_brand_id' => $allBrands['Bose'], 'model_name' => 'Bose SoundLink Mini', 'created_at' => now(), 'updated_at' => now()],

    // Webcam
    ['device_type_id' => $allTypes['Webcam'], 'device_brand_id' => $allBrands['Logitech'], 'model_name' => 'Logitech C920 Pro HD', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Webcam'], 'device_brand_id' => $allBrands['Razer'], 'model_name' => 'Razer Kiyo Pro', 'created_at' => now(), 'updated_at' => now()],

    // Smartwatch
    ['device_type_id' => $allTypes['Smartwatch'], 'device_brand_id' => $allBrands['Apple'], 'model_name' => 'Apple Watch Series 8', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartwatch'], 'device_brand_id' => $allBrands['Samsung'], 'model_name' => 'Samsung Galaxy Watch 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartwatch'], 'device_brand_id' => $allBrands['Garmin'], 'model_name' => 'Garmin Fenix 7', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Smartwatch'], 'device_brand_id' => $allBrands['Fitbit'], 'model_name' => 'Fitbit Sense 2', 'created_at' => now(), 'updated_at' => now()],

    // Gaming Console
    ['device_type_id' => $allTypes['Gaming Console'], 'device_brand_id' => $allBrands['Sony'], 'model_name' => 'PlayStation 5', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Gaming Console'], 'device_brand_id' => $allBrands['Microsoft'], 'model_name' => 'Xbox Series X', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Gaming Console'], 'device_brand_id' => $allBrands['Nintendo'], 'model_name' => 'Nintendo Switch OLED', 'created_at' => now(), 'updated_at' => now()],
    ['device_type_id' => $allTypes['Gaming Console'], 'device_brand_id' => $allBrands['Nintendo'], 'model_name' => 'Nintendo Switch Lite', 'created_at' => now(), 'updated_at' => now()],
];

echo "Adding " . count($comprehensiveModels) . " device models...\n";
foreach ($comprehensiveModels as $model) {
    DB::table('device_models')->insertOrIgnore($model);
}

// Display summary
$totalTypes = DB::table('device_types')->count();
$totalBrands = DB::table('device_brands')->count();
$totalModels = DB::table('device_models')->count();

echo "\n=== Device Data Summary ===\n";
echo "Total Device Types: $totalTypes\n";
echo "Total Device Brands: $totalBrands\n";
echo "Total Device Models: $totalModels\n";
echo "\n✓ All device data added successfully!\n";
