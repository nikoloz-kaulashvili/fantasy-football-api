<?php

namespace App\Services\Api;

use App\Models\Team;

class PlayerGeneratorService
{
    private const POSITIONS = [
        'GK' => 3,
        'DF' => 6,
        'MF' => 6,
        'FW' => 5,
    ];

    private const STARTERS = [
        'GK' => 1,
        'DF' => 4,
        'MF' => 4,
        'FW' => 2,
    ];

    public function generateForTeam(Team $team): void
    {
        $players = [];

        foreach (self::POSITIONS as $position => $count) {

            $starterLimit = self::STARTERS[$position];

            for ($i = 0; $i < $count; $i++) {

                $players[] = [
                    'team_id' => $team->id,
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'country' => fake()->country(),
                    'age' => random_int(18, 40),
                    'position' => $position,
                    'squad_role' => $i < $starterLimit ? 'starter' : 'bench',
                    'market_value' => 1000000 * 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $team->players()->insert($players);
    }
}
