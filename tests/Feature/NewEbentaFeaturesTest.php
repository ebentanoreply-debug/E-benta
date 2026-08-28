<?php

namespace Tests\Feature;

use App\Models\DeviceType;
use App\Models\Listing;
use App\Models\Offer;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewEbentaFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('r2');
    }

    public function test_seller_can_create_bulk_lot_listing_with_handover_preference()
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'email_verified_at' => now(),
        ]);
        $deviceType = DeviceType::create([
            'name' => 'Mobile Phones',
            'base_carbon_footprint' => 50,
            'estimated_weight' => 0.2,
        ]);

        $response = $this->actingAs($seller)->post(route('listings.store'), [
            'device_type_id' => $deviceType->id,
            'device_details' => 'Box of 10 broken smartphones for scrap',
            'condition' => 'non_functional',
            'intended_action' => 'sell',
            'suggested_price' => 1500.00,
            'description' => 'Various Samsung and Xiaomi phones with broken screens and motherboards.',
            'listing_type' => 'bulk_lot',
            'lot_item_count' => 10,
            'handover_preference' => 'pickup_only',
            'pickup_address' => 'Unit 102 Green Residences, Taft Ave, Manila',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', [
            'user_id' => $seller->id,
            'listing_type' => 'bulk_lot',
            'lot_item_count' => 10,
            'handover_preference' => 'pickup_only',
            'pickup_address' => 'Unit 102 Green Residences, Taft Ave, Manila',
            'intended_action' => 'sell',
        ]);
    }

    public function test_seller_requires_pickup_address_when_doorstep_pickup_is_selected()
    {
        $seller = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $deviceType = DeviceType::create([
            'name' => 'Tablets',
            'base_carbon_footprint' => 30,
            'estimated_weight' => 0.5,
        ]);

        $response = $this->actingAs($seller)->post(route('listings.store'), [
            'device_type_id' => $deviceType->id,
            'condition' => 'working',
            'intended_action' => 'sell',
            'suggested_price' => 2000.00,
            'description' => 'Working iPad tablet',
            'handover_preference' => 'pickup_only',
            'pickup_address' => '',
        ]);

        $response->assertSessionHasErrors('pickup_address');
    }

    public function test_buyer_creating_pickup_offer_automatically_uses_seller_pickup_address()
    {
        $seller = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $buyer = User::factory()->create(['role' => 'buyer', 'email_verified_at' => now(), 'is_verified' => true]);
        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Recycle scrap metal',
            'condition' => 'non_functional',
            'intended_action' => 'recycle',
            'handover_preference' => 'pickup_only',
            'pickup_address' => '456 Warehouse Blvd, Pasig City',
            'status' => 'available',
        ]);

        $response = $this->actingAs($buyer)->post(route('offers.store', $listing), [
            'bid_amount' => 500,
            'proposed_method' => 'dispose',
            'handover_method' => 'pickup',
            'proposed_pickup_date' => now()->addDays(3)->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('offers', [
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'handover_method' => 'pickup',
            'pickup_location' => '456 Warehouse Blvd, Pasig City',
        ]);
    }

    public function test_listings_index_can_be_filtered_by_seller_id()
    {
        $seller1 = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $seller2 = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);

        $listing1 = Listing::create([
            'user_id' => $seller1->id,
            'description' => 'Seller 1 listing',
            'condition' => 'working',
            'intended_action' => 'sell',
            'status' => 'available',
        ]);

        $listing2 = Listing::create([
            'user_id' => $seller2->id,
            'description' => 'Seller 2 listing',
            'condition' => 'working',
            'intended_action' => 'sell',
            'status' => 'available',
        ]);

        $response = $this->get(route('listings.index', ['seller_id' => $seller1->id]));
        $response->assertStatus(200);
        $response->assertSee('Seller 1 listing');
        $response->assertDontSee('Seller 2 listing');
    }

    public function test_buyer_can_cancel_pending_offer_without_reason()
    {
        $seller = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $buyer = User::factory()->create(['role' => 'buyer', 'email_verified_at' => now()]);
        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Smartphone for parts',
            'condition' => 'non_functional',
            'intended_action' => 'sell',
            'suggested_price' => 500,
            'status' => 'available',
        ]);
        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 450,
            'proposed_method' => 'harvest',
            'proposed_pickup_date' => now()->addDays(2),
            'pickup_location' => 'Main St',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($buyer)->post(route('offers.cancel', $offer));

        $response->assertRedirect();
        $this->assertEquals('cancelled', $offer->fresh()->status);
    }

    public function test_buyer_cannot_cancel_accepted_offer_without_reason()
    {
        $seller = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $buyer = User::factory()->create(['role' => 'buyer', 'email_verified_at' => now()]);
        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Smartphone for parts',
            'condition' => 'non_functional',
            'intended_action' => 'sell',
            'suggested_price' => 500,
            'status' => 'matched',
        ]);
        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 450,
            'proposed_method' => 'harvest',
            'proposed_pickup_date' => now()->addDays(2),
            'pickup_location' => 'Main St',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($buyer)->post(route('offers.cancel', $offer), []);
        $response->assertSessionHasErrors('cancellation_reason');
        $this->assertEquals('accepted', $offer->fresh()->status);
    }

    public function test_buyer_cancelling_accepted_offer_with_reason_restores_listing_status()
    {
        $seller = User::factory()->create(['role' => 'seller', 'email_verified_at' => now()]);
        $buyer = User::factory()->create(['role' => 'buyer', 'email_verified_at' => now()]);
        $listing = Listing::create([
            'user_id' => $seller->id,
            'description' => 'Smartphone for parts',
            'condition' => 'non_functional',
            'intended_action' => 'sell',
            'suggested_price' => 500,
            'status' => 'matched',
            'matched_buyer_id' => $buyer->id,
        ]);
        $offer = Offer::create([
            'listing_id' => $listing->id,
            'buyer_id' => $buyer->id,
            'bid_amount' => 450,
            'proposed_method' => 'harvest',
            'proposed_pickup_date' => now()->addDays(2),
            'pickup_location' => 'Main St',
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($buyer)->post(route('offers.cancel', $offer), [
            'cancellation_reason' => 'Could not schedule pickup on agreed date due to emergency',
        ]);

        $response->assertRedirect();
        $this->assertEquals('cancelled', $offer->fresh()->status);
        $this->assertEquals('Could not schedule pickup on agreed date due to emergency', $offer->fresh()->cancellation_reason);
        $this->assertEquals('available', $listing->fresh()->status);
    }

    public function test_admin_warning_3_strikes_automatically_bans_user()
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $violator = User::factory()->create([
            'role' => 'seller',
            'warning_count' => 2,
            'is_banned' => false,
            'email_verified_at' => now(),
        ]);

        $report = Report::create([
            'user_id' => $admin->id,
            'reportable_type' => User::class,
            'reportable_id' => $violator->id,
            'reason' => 'spam',
            'description' => 'Repeated violations description',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.reports.resolve', $report), [
            'action_taken' => 'warning_sent',
            'admin_notes' => 'Third strike issued for policy violations',
        ]);

        $response->assertRedirect();
        $violator->refresh();
        $this->assertEquals(3, $violator->warning_count);
        $this->assertTrue((bool)$violator->is_banned);
    }

    public function test_admin_can_suspend_user_for_days()
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $violator = User::factory()->create([
            'role' => 'seller',
            'is_suspended' => false,
            'email_verified_at' => now(),
        ]);

        $report = Report::create([
            'user_id' => $admin->id,
            'reportable_type' => User::class,
            'reportable_id' => $violator->id,
            'reason' => 'harassment_abuse',
            'description' => 'Inappropriate behavior details',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.reports.resolve', $report), [
            'action_taken' => 'user_suspended',
            'suspension_days' => 7,
            'admin_notes' => 'Suspended for 7 days due to harassment report',
        ]);

        $response->assertRedirect();
        $violator->refresh();
        $this->assertTrue((bool)$violator->is_suspended);
        $this->assertNotNull($violator->suspended_until);
        $this->assertTrue($violator->suspended_until->isFuture());
    }

    public function test_user_can_submit_valid_id_for_verification()
    {
        $user = User::factory()->create(['role' => 'buyer', 'email_verified_at' => now()]);

        $idPhoto = UploadedFile::fake()->image('id_front.jpg', 600, 400);
        $selfie = UploadedFile::fake()->image('selfie.jpg', 600, 400);

        $response = $this->actingAs($user)->post(route('settings.id-verification.submit'), [
            'id_type' => 'Philippine National ID (PhilSys)',
            'id_number' => '1234-5678-9012-3456',
            'id_photo' => $idPhoto,
            'id_selfie' => $selfie,
        ]);

        $response->assertRedirect();
        $user->refresh();
        $this->assertEquals('Philippine National ID (PhilSys)', $user->id_type);
        $this->assertEquals('1234-5678-9012-3456', $user->id_number);
        $this->assertEquals('pending', $user->id_verification_status);
        $this->assertNotNull($user->id_photo_url);
    }
}
