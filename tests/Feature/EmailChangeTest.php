<?php

namespace Tests\Feature;

use App\Mail\EmailChangeVerificationMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_change_request_sends_verification_email(): void
    {
        Mail::fake();
        $user = User::factory()->create([
            'email' => 'current@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->post(route('email.change.send'), [
            'new_email' => 'new@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('settings'));
        $this->assertDatabaseHas('email_change_tokens', [
            'user_id' => $user->id,
            'new_email' => 'new@example.com',
            'used' => 0,
        ]);
        Mail::assertSent(EmailChangeVerificationMail::class, function (EmailChangeVerificationMail $mail): bool {
            return $mail->hasTo('new@example.com');
        });
    }
}
