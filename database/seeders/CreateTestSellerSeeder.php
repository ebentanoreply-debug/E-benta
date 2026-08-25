<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateTestSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if seller already exists
        $seller = User::where('email', 'seller@test.com')->first();

        if (!$seller) {
            User::create([
                'name' => 'Test Seller',
                'email' => 'seller@test.com',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'is_verified' => true,
            ]);

            echo "\n✓ Created test seller account:\n";
            echo "  Email: seller@test.com\n";
            echo "  Password: password123\n";
        } else {
            echo "\n✓ Test seller already exists\n";
            echo "  Email: seller@test.com\n";
        }
    }
}
