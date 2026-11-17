<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$listing = \App\Models\Listing::find(330006);
echo "Listing 330006: " . ($listing ? json_encode($listing->only(['id', 'category', 'status', 'user_id', 'price', 'carbon_footprint'])) : 'null') . "\n";

$offer = \App\Models\Offer::find(330006);
echo "Offer 330006: " . ($offer ? json_encode($offer->only(['id', 'listing_id', 'buyer_id', 'status', 'bid_amount'])) : 'null') . "\n";

$offersForListing = \App\Models\Offer::where('listing_id', 330006)->get();
echo "Offers for Listing 330006 count: " . $offersForListing->count() . "\n";
foreach ($offersForListing as $off) {
    echo "  Offer ID: {$off->id}, Buyer: {$off->buyer_id}, Status: {$off->status}\n";
}
