<?php

namespace Tests\Feature\Api\Player;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_own_player(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $player = Player::factory()->create(['team_id' => $team->id]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/v1/players/{$player->id}", [
                'first_name' => [
                    'en' => 'Giorgi',
                    'ka' => 'გიორგი',
                ],
                'last_name' => [
                    'en' => 'Kvaratskhelia',
                    'ka' => 'კვარაცხელია',
                ],
                'country' => [
                    'en' => 'Georgia',
                    'ka' => 'საქართველო',
                ],
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $player->refresh();

        $this->assertSame('Giorgi', $player->getTranslation('first_name', 'en'));
        $this->assertSame('გიორგი', $player->getTranslation('first_name', 'ka'));
        $this->assertSame('Kvaratskhelia', $player->getTranslation('last_name', 'en'));
        $this->assertSame('კვარაცხელია', $player->getTranslation('last_name', 'ka'));
        $this->assertSame('Georgia', $player->getTranslation('country', 'en'));
        $this->assertSame('საქართველო', $player->getTranslation('country', 'ka'));
    }

    public function test_user_cannot_update_another_users_player(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherTeam = Team::factory()->create(['user_id' => $otherUser->id]);
        $player = Player::factory()->create(['team_id' => $otherTeam->id]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/v1/players/{$player->id}", [
                'first_name' => [
                    'en' => 'Giorgi',
                    'ka' => 'გიორგი',
                ],
                'last_name' => [
                    'en' => 'Kvaratskhelia',
                    'ka' => 'კვარაცხელია',
                ],
                'country' => [
                    'en' => 'Georgia',
                    'ka' => 'საქართველო',
                ],
            ]);

        $response->assertForbidden();
    }
}
