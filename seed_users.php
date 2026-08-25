<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create admin
User::firstOrCreate(
    ['email' => 'admin@test.com'],
    [
        'name' => 'Admin User',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'is_verified' => true,
    ]
);
echo "✓ Admin user created/verified\n";

// Create test seller
User::firstOrCreate(
    ['email' => 'seller@test.com'],
    [
        'name' => 'Test Seller',
        'password' => Hash::make('password123'),
        'role' => 'seller',
        'is_verified' => true,
    ]
);
echo "✓ Test seller created/verified\n";

// Create test buyers
for ($i = 1; $i <= 5; $i++) {
    User::firstOrCreate(
        ['email' => "buyer$i@test.com"],
        [
            'name' => "Test Buyer $i",
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'is_verified' => true,
        ]
    );
}
echo "✓ Test buyers (5) created/verified\n";

echo "\n=== Test Accounts Created ===\n";
echo "Admin: admin@test.com / password123\n";
echo "Seller: seller@test.com / password123\n";
echo "Buyers: buyer1-5@test.com / password123\n";
