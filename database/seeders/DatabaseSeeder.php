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
        // Seed devices only (these are reference data)
        $this->call([
            DeviceSeeder::class,
        ]);

        // Create test admin account
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Create test seller account
        User::factory()->create([
            'name' => 'Test Seller',
            'email' => 'seller@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'seller',
            'is_verified' => true,
        ]);

        // Create test buyer accounts
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => "Test Buyer $i",
                'email' => "buyer$i@test.com",
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'buyer',
                'is_verified' => true,
            ]);
        }

        // Create additional random users
        User::factory(5)->create();
    }
}
