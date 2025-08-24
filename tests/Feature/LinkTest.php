<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LinkTest extends TestCase
{
    public function test_shortening_links_logged_out()
    {
        $payload = [
            'original_url' => "https://www.google.com/"
        ];

        $response = $this->postJson('/api/admin/links', $payload);

        $response->assertStatus(202);
        $response->assertJsonStructure([
            'message',
            'short_url'
        ]);
    }

    public function test_authenticated_link_shortening()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = ['original_url' => "https://www.google.com/"];
        $response = $this->postJson('/api/admin/links', $payload);

        $response->assertStatus(202);
        $response->assertJsonStructure([
            'message',
            'short_url'
        ]);
    }
}
