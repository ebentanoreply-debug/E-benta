<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed devices only once (reference data)
        $this->call([
            DeviceSeeder::class,
        ]);

        // If admin already exists, skip user seeding to prevent duplicates
        if (User::where('email', 'admin@test.com')->exists()) {
            return;
        }

        // Create test admin account
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // Create test seller account
        User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Test Seller',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'seller',
                'is_verified' => true,
            ]
        );

        // Create test buyer accounts
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "buyer$i@test.com"],
                [
                    'name' => "Test Buyer $i",
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'buyer',
                    'is_verified' => true,
                ]
            );
        }

        // Create additional random users only on fresh database
        if (User::count() <= 7) {
            User::factory(5)->create();
        }
    }
}
