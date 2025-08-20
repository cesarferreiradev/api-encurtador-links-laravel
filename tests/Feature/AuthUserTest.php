<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    public function test_user_login(): void
    {
        $user = User::factory()->create();
        $payload = [
            'email'    => $user->email,
            'password' => 'password',
            'remember' => false
        ];

        $response = $this->postJson('/api/auth/login', $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'token_type',
                'user'
            ]);
    }

    public function test_user_logout(): void
    {
        $user = User::factory()->create();
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => false,
        ]);

        $loginResponse->assertStatus(200);

        $token = $loginResponse->json('token');

        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson([
                'message' => 'Logout successful',
                'status' => 200
            ]);
    }

    public function test_user_failed_login(): void
    {
        $user = User::factory()->create();

        $payload = [
            'email'    => $user->email,
            'password' => 'incorrect-password',
            'remember' => false
        ];

        $response = $this->postJson('/api/auth/login', $payload);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'These credentials do not match our records.',
                'status'  => 401,
                'code'    => 'unauthorized'
            ]);
    }
}
