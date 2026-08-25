<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountRestrictionTest extends TestCase
{
    use RefreshDatabase;

    public function test_suspended_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'suspended@example.com',
            'password' => Hash::make('password'),
            'is_suspended' => true,
        ]);

        $this->post(route('login'), [
            'email' => 'suspended@example.com',
            'password' => 'password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_banned_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'banned@example.com',
            'password' => Hash::make('password'),
            'is_banned' => true,
        ]);

        $this->post(route('login'), [
            'email' => 'banned@example.com',
            'password' => 'password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
