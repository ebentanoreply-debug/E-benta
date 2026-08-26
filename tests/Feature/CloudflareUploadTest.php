<?php

namespace Tests\Feature;

use App\Models\DeviceType;
use App\Models\Listing;
use App\Models\User;
use App\Services\CloudflareStorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CloudflareUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_cloudflare_storage_service_uploads_and_generates_url(): void
    {
        Storage::fake('r2');
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2.url', 'https://pub-test12345.r2.dev');

        $file = UploadedFile::fake()->image('test_image.png');

        $uploadedUrl = CloudflareStorageService::upload($file, 'avatars');

        $this->assertStringStartsWith('https://pub-test12345.r2.dev/avatars/', $uploadedUrl);
    }

    public function test_cloudflare_storage_service_deletes_file_by_url_or_key(): void
    {
        Storage::fake('r2');
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2.url', 'https://pub-test12345.r2.dev');

        $file = UploadedFile::fake()->image('delete_me.jpg');
        $uploadedUrl = CloudflareStorageService::upload($file, 'listings');

        $this->assertNotEmpty($uploadedUrl);

        $deleted = CloudflareStorageService::delete($uploadedUrl);
        $this->assertTrue($deleted);
    }

    public function test_avatar_upload_and_delete_with_cloudflare_storage(): void
    {
        Storage::fake('r2');
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2.url', 'https://pub-test12345.r2.dev');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('my_avatar.png');

        $response = $this->actingAs($user)->post(route('profile.avatar.update'), [
            'avatar' => $file,
        ]);

        $response->assertRedirect();
        $user->refresh();

        $this->assertNotNull($user->avatar);
        $this->assertStringContainsString('pub-test12345.r2.dev', $user->avatar_url);

        // Delete avatar
        $response = $this->actingAs($user)->delete(route('profile.avatar.delete'));
        $response->assertRedirect();
        $user->refresh();

        $this->assertNull($user->avatar);
        $this->assertNull($user->avatar_url);
    }

    public function test_listing_photos_upload_with_cloudflare_storage(): void
    {
        Storage::fake('r2');
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2.url', 'https://pub-test12345.r2.dev');

        $seller = User::factory()->create(['role' => 'seller', 'is_verified' => true]);
        $deviceType = DeviceType::firstOrCreate(['name' => 'Smartphone']);

        $photo1 = UploadedFile::fake()->image('phone1.jpg');
        $photo2 = UploadedFile::fake()->image('phone2.jpg');

        $response = $this->actingAs($seller)->post(route('listings.store'), [
            'device_type_id' => $deviceType->id,
            'condition' => 'working',
            'description' => 'Smartphone in excellent condition',
            'intended_action' => 'sell',
            'suggested_price' => 5000,
            'photos' => [$photo1, $photo2],
        ]);

        $response->assertRedirect(route('seller.dashboard'));

        $listing = Listing::where('user_id', $seller->id)->latest()->first();
        $this->assertNotNull($listing);
        $this->assertCount(2, $listing->photos);
        $this->assertStringContainsString('pub-test12345.r2.dev', $listing->photos[0]);
    }
}
