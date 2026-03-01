<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_team(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Nika',
            'email' => 'nika@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'nika@test.com')->first();
        $this->assertNotNull($user);

        $team = $user->team;
        $this->assertNotNull($team);
        $this->assertEquals(5000000, $team->budget);

        $players = $team->players;

        $this->assertCount(20, $players);

        $this->assertEquals(3, $players->where('position', 'GK')->count());
        $this->assertEquals(6, $players->where('position', 'DF')->count());
        $this->assertEquals(6, $players->where('position', 'MF')->count());
        $this->assertEquals(5, $players->where('position', 'FW')->count());

        foreach ($players as $player) {
            $this->assertEquals(1000000, $player->market_value);
            $this->assertGreaterThanOrEqual(18, $player->age);
            $this->assertLessThanOrEqual(40, $player->age);
        }
    }
}
