<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_notification_preferences(): void
    {
        $user = User::factory()->create([
            'email_notifications' => true,
            'sms_notifications' => false,
            'marketing_updates' => true,
        ]);

        $response = $this->actingAs($user)->put(route('settings.notifications.update'), [
            'email_notifications' => false,
            'sms_notifications' => true,
            'marketing_updates' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email_notifications' => 0,
            'sms_notifications' => 1,
            'marketing_updates' => 0,
        ]);
    }
}
