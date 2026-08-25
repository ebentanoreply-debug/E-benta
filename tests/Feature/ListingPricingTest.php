<?php

namespace Tests\Feature;

use App\Models\DeviceBrand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_price_is_taken_from_the_listing_form(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_verified' => true,
        ]);

        $deviceType = DeviceType::create([
            'name' => 'Laptop',
        ]);
        $deviceBrand = DeviceBrand::create([
            'name' => 'Dell',
        ]);
        $deviceModel = DeviceModel::create([
            'device_type_id' => $deviceType->id,
            'device_brand_id' => $deviceBrand->id,
            'model_name' => 'Latitude 5420',
        ]);

        $response = $this->actingAs($seller, 'web')->post('/listings', [
            'device_type_id' => $deviceType->id,
            'device_brand_id' => $deviceBrand->id,
            'device_model_id' => $deviceModel->id,
            'device_details' => 'Older business laptop',
            'condition' => 'working',
            'description' => 'Dell Latitude in good condition',
            'intended_action' => 'sell',
            'suggested_price' => 1250.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', [
            'user_id' => $seller->id,
            'device_type_id' => $deviceType->id,
            'device_brand_id' => $deviceBrand->id,
            'device_model_id' => $deviceModel->id,
            'device_details' => 'Older business laptop',
            'suggested_price' => 1250.00,
        ]);

        $listing = Listing::first();
        $this->assertSame('1250.00', (string) $listing->suggested_price);
    }
}
