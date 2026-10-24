<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== All Users in Database ===\n";
$seller = User::where('email', 'seller@test.com')->first();
echo "Seller: ID {$seller->id} | {$seller->name} | {$seller->email} | Role: {$seller->role} | Verified: {$seller->is_verified}\n";

$listings = DB::table('listings')->where('user_id', $seller->id)->where('id', '>=', 19)->get();
echo "Found " . $listings->count() . " products for Seller:\n";
foreach ($listings as $l) {
    echo "  Listing #{$l->id} | Price: ₱{$l->suggested_price} | Status: {$l->status} | Photo: {$l->photos}\n";
}

$listingIds = $listings->pluck('id')->toArray();
$offers = DB::table('offers')->whereIn('listing_id', $listingIds)->get();
echo "Found " . $offers->count() . " offers for Seller's products:\n";
foreach ($offers as $o) {
    $buyer = DB::table('users')->where('id', $o->buyer_id)->first();
    echo "  Offer #{$o->id} on Listing #{$o->listing_id} by {$buyer->name} ({$buyer->email}) | ₱{$o->bid_amount} | Status: {$o->status}\n";
}

