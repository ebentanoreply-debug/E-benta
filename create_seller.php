<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if test seller already exists
$seller = User::where('email', 'seller@test.com')->first();

if ($seller) {
    echo "Seller account already exists\n";
    echo "Email: seller@test.com\n";
} else {
    $seller = User::create([
        'name' => 'Test Seller',
        'email' => 'seller@test.com',
        'password' => Hash::make('password123'),
        'role' => 'seller',
        'is_verified' => true,
    ]);
    echo "Created test seller account:\n";
    echo "Email: seller@test.com\n";
    echo "Password: password123\n";
}
