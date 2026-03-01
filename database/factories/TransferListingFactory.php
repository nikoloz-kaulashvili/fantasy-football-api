<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferListingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'seller_team_id' => Team::factory(),
            'price' => rand(1500000, 3000000),
            'is_active' => 1,
        ];
    }
}