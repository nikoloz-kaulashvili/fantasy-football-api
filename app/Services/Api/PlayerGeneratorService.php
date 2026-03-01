<?php

namespace App\Services\Api;

use App\Models\Team;
use App\Support\Factories\FirstNameFactory;
use App\Support\Factories\LastNameFactory;
use App\Support\Factories\CountryFactory;

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
        foreach (self::POSITIONS as $position => $count) {

            $starterLimit = self::STARTERS[$position];

            for ($i = 0; $i < $count; $i++) {

                $team->players()->create([
                    'first_name' => FirstNameFactory::random(),
                    'last_name'  => LastNameFactory::random(),
                    'country'    => CountryFactory::random(),
                    'age'        => random_int(18, 40),
                    'position'   => $position,
                    'squad_role' => $i < $starterLimit ? 'starter' : 'bench',
                    'market_value' => 1000000 * 100,
                ]);
            }
        }
    }
}
