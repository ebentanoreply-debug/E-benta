<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

echo "=== Seeding System Data (Excluding Listings) ===\n\n";

// Get users
$admin = User::where('email', 'admin@test.com')->first();
$seller = User::where('email', 'seller@test.com')->first();
$buyers = User::where('role', 'buyer')->get();

// Create addresses for users
echo "Creating addresses...\n";

// Admin address
Address::firstOrCreate(
    ['user_id' => $admin->id, 'label' => 'Office'],
    [
        'address_line_1' => '123 Admin Street',
        'city' => 'Manila',
        'state' => 'Metro Manila',
        'postal_code' => '1200',
        'country' => 'Philippines',
        'is_primary' => true,
        'type' => 'both',
    ]
);

// Seller address
Address::firstOrCreate(
    ['user_id' => $seller->id, 'label' => 'Business Location'],
    [
        'address_line_1' => '456 Business Avenue',
        'city' => 'Cebu',
        'state' => 'Cebu',
        'postal_code' => '6000',
        'country' => 'Philippines',
        'is_primary' => true,
        'type' => 'pickup',
    ]
);

// Buyer addresses
$buyerCities = ['Davao', 'Quezon City', 'Makati', 'Pasig', 'Caloocan'];
foreach ($buyers as $index => $buyer) {
    Address::firstOrCreate(
        ['user_id' => $buyer->id, 'label' => 'Home'],
        [
            'address_line_1' => (($index + 1) * 100) . ' Customer Lane',
            'city' => $buyerCities[$index % count($buyerCities)],
            'state' => 'Various',
            'postal_code' => '1000' . ($index + 1),
            'country' => 'Philippines',
            'is_primary' => true,
            'type' => 'dropoff',
        ]
    );
    
    // Add secondary address for first 3 buyers
    if ($index < 3) {
        Address::firstOrCreate(
            ['user_id' => $buyer->id, 'label' => 'Work'],
            [
                'address_line_1' => (($index + 1) * 200) . ' Secondary Road',
                'city' => 'Secondary City',
                'state' => 'Secondary Province',
                'postal_code' => '2000' . ($index + 1),
                'country' => 'Philippines',
                'is_primary' => false,
                'type' => 'both',
            ]
        );
    }
}

echo "✓ Addresses created\n";

// Database info summary
echo "\n=== Database Seeding Complete ===\n";
echo "Total Users:\n";
echo "  - Admins: 1 (admin@test.com)\n";
echo "  - Sellers: 1 (seller@test.com)\n";
echo "  - Buyers: 5 (buyer1-5@test.com)\n";
echo "  - Total: " . User::count() . "\n\n";

echo "Addresses: " . Address::count() . "\n";
echo "Device Types: " . \App\Models\DeviceType::count() . "\n";
echo "Device Brands: " . \App\Models\DeviceBrand::count() . "\n";
echo "Device Models: " . \App\Models\DeviceModel::count() . "\n";

echo "\n✓ All system data seeded successfully!\n";
echo "Note: Listings, offers, transactions, reviews, and other dependent data\n";
echo "can be created once listings are added to the system.\n";
