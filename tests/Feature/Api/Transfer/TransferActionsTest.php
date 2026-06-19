<?php

namespace Tests\Feature\Api\Transfer;

use App\Models\Player;
use App\Models\Team;
use App\Models\Transfer;
use App\Models\TransferListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_all_transfers(): void
    {
        $user = User::factory()->create();
        $transfer = $this->createTransfer();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/transfers');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1);

        $this->assertDatabaseHas('transfers', [
            'id' => $transfer->id,
        ]);
    }

    public function test_user_can_fetch_only_own_team_transfers(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);

        $ownTransfer = $this->createTransfer([
            'buyer_team_id' => $team->id,
        ]);

        $this->createTransfer();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/v1/my-transfers');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1);

        $this->assertDatabaseHas('transfers', [
            'id' => $ownTransfer->id,
            'buyer_team_id' => $team->id,
        ]);
    }

    private function createTransfer(array $overrides = []): Transfer
    {
        $sellerTeam = Team::factory()->create();
        $buyerTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $buyerTeam->id]);
        $listing = TransferListing::factory()->create([
            'player_id' => $player->id,
            'seller_team_id' => $sellerTeam->id,
            'is_active' => 0,
        ]);

        return Transfer::create(array_merge([
            'player_id' => $player->id,
            'seller_team_id' => $sellerTeam->id,
            'buyer_team_id' => $buyerTeam->id,
            'transfer_listing_id' => $listing->id,
            'price' => 1000000,
            'market_value_before' => 1000000,
            'market_value_after' => 1500000,
        ], $overrides));
    }
}
