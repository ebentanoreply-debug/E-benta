<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== All Users in Database ===\n";
$users = User::all(['id', 'name', 'email', 'role', 'is_verified']);
foreach ($users as $user) {
    echo sprintf(
        "ID: %d | Name: %s | Email: %s | Role: %s | Verified: %s\n",
        $user->id,
        $user->name,
        $user->email,
        $user->role,
        $user->is_verified ? 'Yes' : 'No'
    );
}
