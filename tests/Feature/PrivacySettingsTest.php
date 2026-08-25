<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivacySettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_visibility(): void
    {
        $user = User::factory()->create(['profile_visibility' => 'public']);

        $response = $this->actingAs($user)->put(route('settings.privacy.update'), [
            'profile_visibility' => 'private',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_visibility' => 'private',
        ]);
    }

    public function test_private_profile_is_not_visible_to_other_users(): void
    {
        $profileOwner = User::factory()->create(['profile_visibility' => 'private']);
        $viewer = User::factory()->create();

        $this->actingAs($viewer)
            ->get(route('users.show', $profileOwner))
            ->assertNotFound();
    }

    public function test_reviews_for_private_profile_are_not_visible_to_other_users(): void
    {
        $profileOwner = User::factory()->create(['profile_visibility' => 'private']);
        $viewer = User::factory()->create();

        $this->actingAs($viewer)
            ->get(route('reviews.user', $profileOwner))
            ->assertNotFound();
    }

    public function test_direct_review_for_private_profile_is_not_visible_to_other_users(): void
    {
        $profileOwner = User::factory()->create(['profile_visibility' => 'private']);
        $reviewer = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $profileOwner->id]);
        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $reviewer->id,
            'bid_amount' => 100,
            'proposed_method' => 'repair',
            'proposed_pickup_date' => now()->addDay(),
            'status' => 'completed',
        ]);

        $review = \App\Models\Review::create([
            'reviewer_id' => $reviewer->id,
            'reviewee_id' => $profileOwner->id,
            'offer_id' => $offer->id,
            'rating' => 5,
            'title' => 'Great',
            'comment' => 'Helpful transaction',
            'review_type' => 'seller',
            'is_verified' => true,
        ]);

        $this->actingAs($reviewer)
            ->get(route('reviews.show', $review))
            ->assertNotFound();
    }
}
