<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_uses_normalized_token_table_and_mail(): void
    {
        Mail::fake();
        $user = User::factory()->create(['email' => 'reset@example.com']);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $token = PasswordResetToken::where('user_id', $user->id)->firstOrFail();
        Mail::assertSent(PasswordResetMail::class);

        $response = $this->get(route('password.reset', [
            'token' => $token->token,
            'email' => $user->email,
        ]));

        $response->assertOk();

        $response = $this->post(route('password.verify-code'), [
            'email' => $user->email,
            'code' => $token->token,
        ]);

        $response->assertRedirect(route('password.new'));

        $response = $this->post(route('password.update-new'), [
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
        $this->assertDatabaseHas('password_reset_tokens_new', [
            'id' => $token->id,
            'used' => 1,
        ]);
    }
}
