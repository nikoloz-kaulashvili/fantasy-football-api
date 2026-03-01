<?php

namespace Tests\Feature\Api\Market;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\TransferListing;

class BuyListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_buy_player(): void
    {
        $seller = User::factory()->create();
        $sellerTeam = Team::factory()->create([
            'user_id' => $seller->id,
            'budget' => 5000000,
        ]);

        $buyer = User::factory()->create();
        $buyerTeam = Team::factory()->create([
            'user_id' => $buyer->id,
            'budget' => 5000000,
        ]);

        $player = Player::factory()->create([
            'team_id' => $sellerTeam->id,
            'market_value' => 1000000,
        ]);

        $listing = TransferListing::factory()->create([
            'player_id' => $player->id,
            'seller_team_id' => $sellerTeam->id,
            'price' => 1000000,
            'is_active' => 1,
        ]);

        $initialBuyerBudget = $buyerTeam->budget;
        $initialSellerBudget = $sellerTeam->budget;
        $initialMarketValue = $player->market_value;

        $this->actingAs($buyer);

        $response = $this->postJson("/api/v1/market/listings/{$listing->id}/buy");

        $response->assertOk();

        $buyerTeam->refresh();
        $sellerTeam->refresh();
        $player->refresh();
        $listing->refresh();

        $this->assertEquals($buyerTeam->id, $player->team_id);
        $this->assertFalse((bool) $listing->is_active);

        $this->assertEquals(
            $initialBuyerBudget - $listing->price,
            $buyerTeam->budget
        );

        $this->assertEquals(
            $initialSellerBudget + $listing->price,
            $sellerTeam->budget
        );

        $this->assertGreaterThan($initialMarketValue, $player->market_value);
    }

    public function test_user_cannot_buy_own_player(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
            'budget' => 5000000,
        ]);

        $player = Player::factory()->create([
            'team_id' => $team->id,
            'market_value' => 1000000,
        ]);

        $listing = TransferListing::factory()->create([
            'player_id' => $player->id,
            'seller_team_id' => $team->id,
            'price' => 1000000,
            'is_active' => 1,
        ]);

        $initialBudget = $team->budget;

        $this->actingAs($user);

        $response = $this->postJson("/api/v1/market/listings/{$listing->id}/buy");

        $response->assertStatus(422);

        $team->refresh();
        $player->refresh();
        $listing->refresh();

        $this->assertEquals($team->id, $player->team_id);
        $this->assertEquals($initialBudget, $team->budget);
        $this->assertTrue((bool) $listing->is_active);
    }
}
