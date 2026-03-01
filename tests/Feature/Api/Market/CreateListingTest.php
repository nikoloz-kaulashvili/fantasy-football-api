<?php

namespace Tests\Feature\Api\Market;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\TransferListing;

class CreateListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_listing(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
        ]);

        $player = Player::factory()->create([
            'team_id' => $team->id,
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/api/v1/market/listings', [
            'player_id' => $player->id,
            'price' => 2000000,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('transfer_listings', [
            'player_id' => $player->id,
            'seller_team_id' => $team->id,
            'price' => 2000000,
            'is_active' => 1,
        ]);

        $listing = TransferListing::where('player_id', $player->id)->first();

        $this->assertNotNull($listing);
        $this->assertEquals($team->id, $listing->seller_team_id);
    }
}
