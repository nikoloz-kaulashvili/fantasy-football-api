<?php

namespace Tests\Feature\Api\Team;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_own_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);

        Player::factory()->create([
            'team_id' => $team->id,
            'squad_role' => 'starter',
        ]);

        Player::factory()->create([
            'team_id' => $team->id,
            'squad_role' => 'bench',
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/team');

        $response->assertOk();
    }

    public function test_user_can_update_own_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->patchJson('/api/v1/team', [
                'name' => [
                    'en' => 'Tbilisi Winners',
                    'ka' => 'თბილისის გუნდი',
                ],
                'country' => [
                    'en' => 'Georgia',
                    'ka' => 'საქართველო',
                ],
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $team->refresh();

        $this->assertSame('Tbilisi Winners', $team->getTranslation('name', 'en'));
        $this->assertSame('თბილისის გუნდი', $team->getTranslation('name', 'ka'));
        $this->assertSame('Georgia', $team->getTranslation('country', 'en'));
        $this->assertSame('საქართველო', $team->getTranslation('country', 'ka'));
    }

    public function test_user_can_swap_bench_player_with_starter(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);

        $benchPlayer = Player::factory()->create([
            'team_id' => $team->id,
            'position' => 'DF',
            'squad_role' => 'bench',
        ]);

        $starterPlayer = Player::factory()->create([
            'team_id' => $team->id,
            'position' => 'DF',
            'squad_role' => 'starter',
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/team/swap', [
                'in_player_id' => $benchPlayer->id,
                'out_player_id' => $starterPlayer->id,
            ]);

        $response->assertOk();

        $benchPlayer->refresh();
        $starterPlayer->refresh();

        $this->assertSame('starter', $benchPlayer->squad_role);
        $this->assertSame('bench', $starterPlayer->squad_role);
    }

    public function test_user_cannot_swap_players_from_different_teams(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $otherTeam = Team::factory()->create();

        $benchPlayer = Player::factory()->create([
            'team_id' => $team->id,
            'position' => 'DF',
            'squad_role' => 'bench',
        ]);

        $otherStarter = Player::factory()->create([
            'team_id' => $otherTeam->id,
            'position' => 'DF',
            'squad_role' => 'starter',
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/team/swap', [
                'in_player_id' => $benchPlayer->id,
                'out_player_id' => $otherStarter->id,
            ]);

        $response->assertStatus(404);
    }
}
