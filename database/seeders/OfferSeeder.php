<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all listings
        $listings = Listing::all();
        
        // Get all users who could be buyers
        $users = User::all();

        if ($listings->isEmpty() || $users->count() < 2) {
            $this->command->info('Not enough listings or users to create offers.');
            return;
        }

        foreach ($listings as $listing) {
            // Skip if it's the seller's own listing
            $potentialBuyers = $users->where('id', '!=', $listing->user_id);

            if ($potentialBuyers->isEmpty()) {
                continue;
            }

            // Randomly decide how many offers to create for this listing (0-3)
            $offerCount = random_int(0, 3);

            for ($i = 0; $i < $offerCount; $i++) {
                $buyer = $potentialBuyers->random();
                
                // Check if this buyer already has an offer for this listing
                $existingOffer = Offer::where('listing_id', $listing->id)
                    ->where('buyer_id', $buyer->id)
                    ->first();

                if ($existingOffer) {
                    continue; // Skip duplicate offers from same buyer
                }

                // Create offer with random data
                Offer::create([
                    'listing_id' => $listing->id,
                    'buyer_id' => $buyer->id,
                    'bid_amount' => $this->generateRandomBid($listing->suggested_price),
                    'proposed_method' => $this->getRandomMethod(),
                    'notes' => $this->getRandomNotes(),
                    'proposed_pickup_date' => now()->addDays(random_int(1, 14)),
                    'pickup_location' => 'Pickup Location ' . random_int(1, 5),
                    'status' => $this->getRandomStatus(),
                    'responded_at' => random_int(0, 1) ? now()->subDays(random_int(1, 7)) : null,
                ]);
            }
        }

        $this->command->info('OfferSeeder completed successfully.');
    }

    /**
    * Generate a random bid amount based on the seller's asking price
     */
    private function generateRandomBid($suggestedPrice)
    {
        if ($suggestedPrice == 0) {
            return random_int(100, 500);
        }

        // Bid between 70% and 130% of the seller's asking price
        $minBid = $suggestedPrice * 0.7;
        $maxBid = $suggestedPrice * 1.3;

        return (float) number_format(random_int((int)$minBid * 100, (int)$maxBid * 100) / 100, 2);
    }

    /**
     * Get a random processing method
     */
    private function getRandomMethod()
    {
        $methods = ['repair', 'harvest', 'refine', 'dispose'];
        return $methods[array_rand($methods)];
    }

    /**
     * Get a random status
     */
    private function getRandomStatus()
    {
        $statuses = [
            'pending',      // 30%
            'pending',
            'pending',
            'accepted',     // 25%
            'accepted',
            'accepted',
            'completed',    // 30%
            'completed',
            'completed',
            'rejected',     // 15%
        ];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Get random notes
     */
    private function getRandomNotes()
    {
        $notes = [
            'Interested buyer, ready to pick up immediately',
            'Can offer better price if pickup is flexible',
            'Need this device urgently for project',
            'Will provide excellent care for the device',
            'Bulk buyer - can purchase multiple units',
            'Professional refurbishment facility',
            null,
            null,
        ];
        return $notes[array_rand($notes)];
    }
}
