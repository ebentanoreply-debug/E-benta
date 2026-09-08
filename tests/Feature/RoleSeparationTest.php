<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleSeparationTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_navigation_has_orders_and_no_selling_actions(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer', 'is_verified' => true]);

        foreach (['home', 'listings.index', 'profile', 'settings', 'buyer.dashboard'] as $route) {
            $this->actingAs($buyer)->get(route($route))->assertOk()
                ->assertDontSee('Seller Hub')
                ->assertDontSee('href="'.route('listings.create').'"', false)
                ->assertSee('href="'.route('buyer.dashboard').'"', false);
        }
    }

    public function test_seller_navigation_has_selling_actions_and_no_buyer_actions(): void
    {
        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);

        foreach (['home', 'listings.index', 'profile', 'settings', 'seller.dashboard'] as $route) {
            $this->actingAs($seller)->get(route($route))->assertOk()
                ->assertDontSee('Buyer Hub')
                ->assertDontSee('href="'.route('buyer.dashboard').'"', false)
                ->assertDontSee('href="'.route('buyer.saved-items').'"', false)
                ->assertSee('href="'.route('listings.create').'"', false);
        }
    }

    public function test_buyer_cannot_use_seller_actions_even_when_owning_old_listings(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $listing = Listing::factory()->create(['user_id' => $buyer->id, 'status' => 'available']);
        $offer = $this->makeOffer($listing, User::factory()->create(['role' => 'buyer']));
        $this->actingAs($buyer);

        $this->get(route('seller.dashboard'))->assertRedirect('/');
        $this->get(route('listings.create'))->assertRedirect('/');
        $this->post(route('listings.store'), [])->assertRedirect('/')->assertSessionHas('error');
        $this->put(route('settings.seller.update'), [])->assertRedirect('/')->assertSessionHas('error');
        foreach (['offers.accept', 'offers.reject'] as $route) {
            $this->post(route($route, $offer))->assertRedirect('/')->assertSessionHas('error');
        }
        $this->assertSame('pending', $offer->fresh()->status);
        $this->assertSame(1, Listing::count());
    }

    public function test_seller_cannot_order_or_pay_even_when_owning_an_old_order(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $listing = Listing::factory()->create(['status' => 'available']);
        $offer = $this->makeOffer($listing, $seller);
        $this->actingAs($seller);

        $this->get(route('buyer.dashboard'))->assertRedirect('/');
        $this->get(route('offers.create', $listing))->assertRedirect('/');
        $this->post(route('offers.store', $listing), [])->assertRedirect('/')->assertSessionHas('error');
        foreach (['offers.pay', 'offers.verify-payment', 'offers.cancel', 'offers.payment-method'] as $route) {
            $this->post(route($route, $offer))->assertRedirect('/')->assertSessionHas('error');
        }
        $this->assertSame(1, Offer::count());
    }
    private function makeOffer(Listing $listing, User $buyer): Offer
    {
        return Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 450,
            'proposed_method' => 'harvest',
            'proposed_pickup_date' => now()->addDays(2),
            'pickup_location' => 'Main St',
            'status' => 'pending',
        ]);
    }

}
