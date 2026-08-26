<?php

namespace Tests\Feature;

use App\Models\DeviceType;
use App\Models\Listing;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EnhancementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_and_delete_profile_picture(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post(route('profile.avatar.update'), [
            'avatar' => $file,
        ]);

        $response->assertRedirect();
        $user->refresh();
        $this->assertNotNull($user->avatar);
        $this->assertNotNull($user->avatar_url);

        // Delete avatar
        $response = $this->actingAs($user)->delete(route('profile.avatar.delete'));
        $response->assertRedirect();
        $user->refresh();
        $this->assertNull($user->avatar);
    }

    public function test_seller_cannot_accept_or_reject_offer_on_withdrawn_listing(): void
    {
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);

        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Sample Withdrawn Item Description',
            'condition' => 'good',
            'intended_action' => 'sell',
            'suggested_price' => 500,
            'status' => 'withdrawn',
            'carbon_footprint' => 10,
            'estimated_weight' => 1,
        ]);

        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 450,
            'proposed_method' => 'repair',
            'notes' => 'Test offer',
            'proposed_pickup_date' => now()->addDays(2),
            'status' => 'pending',
        ]);

        // Try accepting
        $response = $this->actingAs($seller)->post(route('offers.accept', $offer));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals('pending', $offer->fresh()->status);

        // Try rejecting
        $response = $this->actingAs($seller)->post(route('offers.reject', $offer));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals('pending', $offer->fresh()->status);
    }

    public function test_buyer_can_view_listing_and_offer_after_completed_transaction(): void
    {
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);

        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Completed Transaction Item Description',
            'condition' => 'good',
            'intended_action' => 'sell',
            'suggested_price' => 1000,
            'status' => 'matched',
            'matched_buyer_id' => $buyer->id,
            'carbon_footprint' => 15,
            'estimated_weight' => 1.5,
        ]);

        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 1000,
            'proposed_method' => 'repair',
            'notes' => 'Done deal',
            'proposed_pickup_date' => now()->subDay(),
            'status' => 'completed',
        ]);

        // Buyer viewing matched listing should succeed (not redirect to / with listing not found)
        $response = $this->actingAs($buyer)->get(route('listings.show', $listing));
        $response->assertOk();
    }

    public function test_notification_open_route_marks_as_read_and_redirects(): void
    {
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);

        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Test Item Description',
            'condition' => 'good',
            'intended_action' => 'sell',
            'suggested_price' => 500,
            'status' => 'available',
            'carbon_footprint' => 10,
            'estimated_weight' => 1,
        ]);

        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 500,
            'proposed_method' => 'repair',
            'proposed_pickup_date' => now()->addDay(),
            'status' => 'accepted',
        ]);

        $notif = Notification::notify(
            $seller,
            'new_message',
            'New message from Buyer',
            'Hello seller!',
            ['offer_id' => $offer->id]
        );

        $this->assertFalse((bool)$notif->is_read);

        $response = $this->actingAs($seller)->get(route('notifications.open', $notif));
        $response->assertRedirect(route('messages.index', ['offer_id' => $offer->id]));

        $notif->refresh();
        $this->assertTrue((bool)$notif->is_read);
    }
}
