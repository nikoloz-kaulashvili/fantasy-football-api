<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_protected_route(): void
    {
        $response = $this->getJson('/api/v1/team');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_route(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/me');

        $response->assertStatus(200);
    }
}