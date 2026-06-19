<?php

namespace Tests\Feature\Api\Market;

use App\Models\Player;
use App\Models\Team;
use App\Models\TransferListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_active_market_listings(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        $activePlayer = Player::factory()->create(['team_id' => $team->id]);
        $inactivePlayer = Player::factory()->create(['team_id' => $team->id]);

        TransferListing::factory()->create([
            'player_id' => $activePlayer->id,
            'seller_team_id' => $team->id,
            'is_active' => 1,
        ]);

        TransferListing::factory()->create([
            'player_id' => $inactivePlayer->id,
            'seller_team_id' => $team->id,
            'is_active' => 0,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/market/listings');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('success', true);
    }

    public function test_user_can_cancel_own_listing(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $player = Player::factory()->create(['team_id' => $team->id]);
        $listing = TransferListing::factory()->create([
            'player_id' => $player->id,
            'seller_team_id' => $team->id,
            'is_active' => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson("/api/v1/market/listings/{$listing->id}");

        $response->assertOk();

        $this->assertDatabaseHas('transfer_listings', [
            'id' => $listing->id,
            'is_active' => 0,
        ]);
    }

    public function test_user_cannot_cancel_another_users_listing(): void
    {
        $user = User::factory()->create();
        Team::factory()->create(['user_id' => $user->id]);

        $seller = User::factory()->create();
        $sellerTeam = Team::factory()->create(['user_id' => $seller->id]);
        $player = Player::factory()->create(['team_id' => $sellerTeam->id]);
        $listing = TransferListing::factory()->create([
            'player_id' => $player->id,
            'seller_team_id' => $sellerTeam->id,
            'is_active' => 1,
        ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson("/api/v1/market/listings/{$listing->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('transfer_listings', [
            'id' => $listing->id,
            'is_active' => 1,
        ]);
    }
}
