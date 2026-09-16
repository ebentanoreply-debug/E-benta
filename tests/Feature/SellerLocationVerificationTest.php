<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerLocationVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_seller_registers_as_unverified_by_default()
    {
        $response = $this->post('/register', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'role' => 'seller',
            'business_name' => 'Juan E-Waste Recycling',
            'phone' => '09171234567',
        ]);

        $response->assertRedirect();
        $user = User::where('email', 'juan@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse((bool) $user->is_verified);
        $this->assertEquals('unsubmitted', $user->id_verification_status);
        $this->assertFalse($user->isSellerVerified());
    }

    public function test_unverified_seller_is_redirected_when_attempting_to_create_listing()
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => false,
            'id_verification_status' => 'unsubmitted',
            'email_verified_at' => now(),
        ]);

        // Attempting to access create form
        $response = $this->actingAs($seller)->get(route('listings.create'));
        $response->assertRedirect(route('settings', ['tab' => 'id-verification']));
        $response->assertSessionHas('error');

        // Attempting to post to store endpoint
        $storeResponse = $this->actingAs($seller)->post(route('listings.store'), [
            'condition' => 'functional',
            'description' => 'Test unverified device',
            'intended_action' => 'recycle',
        ]);
        $storeResponse->assertRedirect(route('settings', ['tab' => 'id-verification']));
        $storeResponse->assertSessionHas('error');
    }

    public function test_seller_can_submit_id_front_back_and_location_details()
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => false,
            'email_verified_at' => now(),
        ]);

        $frontPhoto = UploadedFile::fake()->image('philsys_front.jpg', 600, 400);
        $backPhoto = UploadedFile::fake()->image('philsys_back.jpg', 600, 400);

        $response = $this->actingAs($seller)->post(route('settings.id-verification.submit'), [
            'id_type' => 'Philippine National ID (PhilSys)',
            'id_number' => '9876-5432-1098-7654',
            'id_photo' => $frontPhoto,
            'id_back_photo' => $backPhoto,
            'address_line_1' => 'Unit 501 Emerald Mansion, F. Ortigas Jr. Rd',
            'barangay' => 'San Antonio',
            'address_city' => 'Pasig City',
            'address_province' => 'Metro Manila',
            'postal_code' => '1605',
            'location_notes' => 'Near Ortigas Center, lobby reception',
            'proof_of_address_type' => 'id_address_match',
        ]);

        $response->assertRedirect();
        $seller->refresh();

        $this->assertEquals('pending', $seller->id_verification_status);
        $this->assertEquals('Philippine National ID (PhilSys)', $seller->id_type);
        $this->assertEquals('9876-5432-1098-7654', $seller->id_number);
        $this->assertNotNull($seller->id_photo_url);
        $this->assertNotNull($seller->id_back_photo_url);
        $this->assertEquals('Unit 501 Emerald Mansion, F. Ortigas Jr. Rd', $seller->address_line_1);
        $this->assertEquals('San Antonio', $seller->barangay);
        $this->assertEquals('Pasig City', $seller->address_city);
        $this->assertEquals('Metro Manila', $seller->address_province);
        $this->assertEquals('1605', $seller->postal_code);
        $this->assertNotNull($seller->id_submitted_at);

        // Address synchronization check
        $primaryAddress = $seller->addresses()->where('is_primary', true)->first();
        $this->assertNotNull($primaryAddress);
        $this->assertEquals('Unit 501 Emerald Mansion, F. Ortigas Jr. Rd', $primaryAddress->address_line_1);
        $this->assertEquals('Pasig City', $primaryAddress->city);
    }

    public function test_admin_can_view_seller_pending_verification_with_location_data()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'role' => 'seller',
            'name' => 'Maria Recycling',
            'is_verified' => false,
            'id_verification_status' => 'pending',
            'id_type' => "Driver's License",
            'id_number' => 'N01-23-456789',
            'address_line_1' => '123 Bonifacio St',
            'barangay' => 'Poblacion',
            'address_city' => 'Makati City',
            'address_province' => 'Metro Manila',
            'postal_code' => '1200',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.pending-verifications', ['role' => 'seller']));
        $response->assertOk();
        $response->assertSee('Maria Recycling');
        $response->assertSee('Makati City');
        $response->assertSee('Poblacion');
        $response->assertSee("Driver's License");
    }

    public function test_admin_can_approve_seller_id_and_location()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => false,
            'id_verification_status' => 'pending',
            'address_city' => 'Quezon City',
            'address_province' => 'Metro Manila',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verify-user', $seller));
        $response->assertRedirect(route('admin.pending-verifications'));

        $seller->refresh();
        $this->assertTrue((bool) $seller->is_verified);
        $this->assertEquals('verified', $seller->id_verification_status);
        $this->assertNotNull($seller->location_verified_at);
        $this->assertTrue($seller->isSellerVerified());

        // Check notification received
        $notification = Notification::where('user_id', $seller->id)->latest()->first();
        $this->assertNotNull($notification);
        $this->assertStringContainsString('Seller ID & Location Verified', $notification->title);
    }

    public function test_verified_seller_can_access_listing_creation()
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => true,
            'id_verification_status' => 'verified',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($seller)->get(route('listings.create'));
        $response->assertOk();
    }

    public function test_admin_can_reject_seller_with_location_mismatch_reason()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => false,
            'id_verification_status' => 'pending',
            'email_verified_at' => now(),
        ]);

        $rejectionReason = 'The address on your ID does not match the registered pickup location.';
        $response = $this->actingAs($admin)->post(route('admin.reject-user', $seller), [
            'reason' => $rejectionReason,
        ]);

        $response->assertRedirect(route('admin.pending-verifications'));

        $seller->refresh();
        $this->assertFalse((bool) $seller->is_verified);
        $this->assertEquals('rejected', $seller->id_verification_status);
        $this->assertEquals($rejectionReason, $seller->id_rejection_reason);

        // Check rejection notification
        $notification = Notification::where('user_id', $seller->id)->latest()->first();
        $this->assertNotNull($notification);
        $this->assertStringContainsString($rejectionReason, $notification->message);
    }
}
