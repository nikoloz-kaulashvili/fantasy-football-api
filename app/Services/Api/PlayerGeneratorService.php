<?php

namespace App\Services\Api;

use App\Models\Team;
use App\Support\Factories\FirstNameFactory;
use App\Support\Factories\LastNameFactory;
use App\Support\Factories\CountryFactory;

class PlayerGeneratorService
{

    public function generateForTeam(Team $team): void
    {
        $positions   = config('fantasy.team.positions');
        $starters    = config('fantasy.team.starters');
        $marketValue = config('fantasy.team.initial_market_value');

        foreach ($positions as $position => $count) {

            $starterLimit = $starters[$position] ?? 0;

            for ($i = 0; $i < $count; $i++) {

                $team->players()->create([
                    'first_name'   => FirstNameFactory::random(),
                    'last_name'    => LastNameFactory::random(),
                    'country'      => CountryFactory::random(),
                    'age'          => random_int(18, 40),
                    'position'     => $position,
                    'squad_role'   => $i < $starterLimit ? 'starter' : 'bench',
                    'market_value' => $marketValue,
                ]);
            }
        }
    }
}
