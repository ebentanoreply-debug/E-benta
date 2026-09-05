<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     *Seed the application's database with all reference data and test accounts in one place.
     */
    public function run(): void
    {
        $this->seedDeviceData();
        $this->seedUsers();
        $this->seedAddresses();
        $this->seedOffers();
    }

    /**
     * Seed device types, brands, and models
     */
    private function seedDeviceData(): void
    {
        // 1. Device Types
        $deviceTypes = [
            ['name' => 'Laptop', 'icon' => 'fa-laptop'],
            ['name' => 'Desktop Computer', 'icon' => 'fa-desktop'],
            ['name' => 'Smartphone', 'icon' => 'fa-mobile-alt'],
            ['name' => 'Tablet', 'icon' => 'fa-tablet-alt'],
            ['name' => 'Monitor', 'icon' => 'fa-tv'],
            ['name' => 'Keyboard', 'icon' => 'fa-keyboard'],
            ['name' => 'Mouse', 'icon' => 'fa-mouse'],
            ['name' => 'Printer', 'icon' => 'fa-print'],
            ['name' => 'Router', 'icon' => 'fa-wifi'],
            ['name' => 'Cables & Wires', 'icon' => 'fa-plug'],
            ['name' => 'Headphones', 'icon' => 'fa-headphones'],
            ['name' => 'External Storage', 'icon' => 'fa-hdd'],
        ];

        foreach ($deviceTypes as $type) {
            DB::table('device_types')->updateOrInsert(
                ['name' => $type['name']],
                array_merge($type, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // 2. Device Brands
        $deviceBrands = [
            ['name' => 'Apple'],
            ['name' => 'Dell'],
            ['name' => 'HP'],
            ['name' => 'Lenovo'],
            ['name' => 'ASUS'],
            ['name' => 'Samsung'],
            ['name' => 'LG'],
            ['name' => 'Sony'],
            ['name' => 'Acer'],
            ['name' => 'Intel'],
            ['name' => 'Logitech'],
            ['name' => 'Canon'],
            ['name' => 'TP-Link'],
            ['name' => 'Netgear'],
        ];

        foreach ($deviceBrands as $brand) {
            DB::table('device_brands')->updateOrInsert(
                ['name' => $brand['name']],
                array_merge($brand, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // Fetch IDs for relational model mapping
        $types = DB::table('device_types')->pluck('id', 'name');
        $brands = DB::table('device_brands')->pluck('id', 'name');

        // 3. Device Models
        $models = [
            // Laptops
            ['type' => 'Laptop', 'brand' => 'Apple', 'name' => 'MacBook Pro 13"'],
            ['type' => 'Laptop', 'brand' => 'Apple', 'name' => 'MacBook Air M1'],
            ['type' => 'Laptop', 'brand' => 'Dell', 'name' => 'Dell XPS 13'],
            ['type' => 'Laptop', 'brand' => 'HP', 'name' => 'HP Pavilion 15'],
            ['type' => 'Laptop', 'brand' => 'Lenovo', 'name' => 'Lenovo ThinkPad X1'],
            ['type' => 'Laptop', 'brand' => 'ASUS', 'name' => 'ASUS VivoBook 15'],

            // Desktop Computers
            ['type' => 'Desktop Computer', 'brand' => 'Apple', 'name' => 'iMac 27"'],
            ['type' => 'Desktop Computer', 'brand' => 'Dell', 'name' => 'Dell OptiPlex'],
            ['type' => 'Desktop Computer', 'brand' => 'HP', 'name' => 'HP Pavilion Desktop'],

            // Smartphones
            ['type' => 'Smartphone', 'brand' => 'Apple', 'name' => 'iPhone 13'],
            ['type' => 'Smartphone', 'brand' => 'Apple', 'name' => 'iPhone 12'],
            ['type' => 'Smartphone', 'brand' => 'Samsung', 'name' => 'Samsung Galaxy S21'],
            ['type' => 'Smartphone', 'brand' => 'Samsung', 'name' => 'Samsung Galaxy S22'],

            // Tablets
            ['type' => 'Tablet', 'brand' => 'Apple', 'name' => 'iPad Pro 12.9"'],
            ['type' => 'Tablet', 'brand' => 'Apple', 'name' => 'iPad Air'],
            ['type' => 'Tablet', 'brand' => 'Samsung', 'name' => 'Samsung Galaxy Tab S7'],

            // Monitors
            ['type' => 'Monitor', 'brand' => 'Dell', 'name' => 'Dell U2720Q 27"'],
            ['type' => 'Monitor', 'brand' => 'LG', 'name' => 'LG UltraWide 34"'],
            ['type' => 'Monitor', 'brand' => 'ASUS', 'name' => 'ASUS ProArt 32"'],

            // Accessories
            ['type' => 'Keyboard', 'brand' => 'Apple', 'name' => 'Apple Magic Keyboard'],
            ['type' => 'Keyboard', 'brand' => 'ASUS', 'name' => 'Mechanical RGB Keyboard'],
            ['type' => 'Mouse', 'brand' => 'Logitech', 'name' => 'Logitech MX Master 3'],
            ['type' => 'Mouse', 'brand' => 'Apple', 'name' => 'Apple Magic Mouse'],
            ['type' => 'Printer', 'brand' => 'HP', 'name' => 'HP LaserJet Pro'],
            ['type' => 'Printer', 'brand' => 'Canon', 'name' => 'Canon PIXMA'],
            ['type' => 'Router', 'brand' => 'TP-Link', 'name' => 'TP-Link WiFi 6 Router'],
            ['type' => 'Router', 'brand' => 'Netgear', 'name' => 'Netgear Nighthawk'],
        ];

        foreach ($models as $m) {
            if (isset($types[$m['type']]) && isset($brands[$m['brand']])) {
                DB::table('device_models')->updateOrInsert(
                    [
                        'device_type_id' => $types[$m['type']],
                        'device_brand_id' => $brands[$m['brand']],
                        'model_name' => $m['name'],
                    ],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    /**
     * Seed users (Admin, Seller, Buyers)
     */
    private function seedUsers(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // Seller
        User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Test Seller',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'is_verified' => true,
            ]
        );

        // Buyers
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

        // Additional random users if needed
        if (User::count() <= 7 && class_exists(\Database\Factories\UserFactory::class)) {
            User::factory(5)->create();
        }
    }

    /**
     * Seed user addresses
     */
    private function seedAddresses(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();
        $seller = User::where('email', 'seller@test.com')->first();
        $buyers = User::where('role', 'buyer')->get();

        if ($admin) {
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
        }

        if ($seller) {
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
        }

        $buyerCities = ['Davao', 'Quezon City', 'Makati', 'Pasig', 'Caloocan'];
        foreach ($buyers as $index => $buyer) {
            Address::firstOrCreate(
                ['user_id' => $buyer->id, 'label' => 'Home'],
                [
                    'address_line_1' => (($index + 1) * 100) . ' Customer Lane',
                    'city' => $buyerCities[$index % count($buyerCities)],
                    'state' => 'Metro Manila',
                    'postal_code' => '100' . ($index + 1),
                    'country' => 'Philippines',
                    'is_primary' => true,
                    'type' => 'shipping',
                ]
            );
        }
    }

    /**
     * Seed sample offers if listings exist
     */
    private function seedOffers(): void
    {
        $listings = Listing::all();
        $users = User::where('role', 'buyer')->get();

        if ($listings->isEmpty() || $users->isEmpty()) {
            return;
        }

        $methods = ['repair', 'harvest', 'refine', 'dispose'];
        $statuses = ['pending', 'accepted', 'completed', 'rejected'];

        foreach ($listings as $listing) {
            $potentialBuyers = $users->where('id', '!=', $listing->user_id);
            if ($potentialBuyers->isEmpty()) {
                continue;
            }

            $offerCount = random_int(0, 2);
            for ($i = 0; $i < $offerCount; $i++) {
                $buyer = $potentialBuyers->random();

                $exists = Offer::where('listing_id', $listing->id)
                    ->where('buyer_id', $buyer->id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                $price = $listing->suggested_price ?? 500;
                $bidAmount = max(100, (float) number_format($price * (random_int(70, 130) / 100), 2));

                Offer::create([
                    'listing_id' => $listing->id,
                    'buyer_id' => $buyer->id,
                    'bid_amount' => $bidAmount,
                    'proposed_method' => $methods[array_rand($methods)],
                    'notes' => 'Interested in purchasing this device.',
                    'proposed_pickup_date' => now()->addDays(random_int(1, 10)),
                    'pickup_location' => 'Pickup Location ' . random_int(1, 3),
                    'status' => $statuses[array_rand($statuses)],
                    'responded_at' => random_int(0, 1) ? now()->subDays(random_int(1, 5)) : null,
                ]);
            }
        }
    }
}
