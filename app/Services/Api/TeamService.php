<?php

namespace App\Services\Api;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Support\Factories\CountryFactory;

class TeamService
{
    public function __construct(
        protected PlayerGeneratorService $playerGenerator
    ) {}

    public function createForUser(User $user): Team
    {
        return DB::transaction(function () use ($user) {

            $team = Team::create([
                'user_id' => $user->id,

                'name' => [
                    'en' => "{$user->name}'s Team",
                    'ka' => "{$user->name}-ის გუნდი",
                ],

                'country' => CountryFactory::random(),

                'budget' => 5000000 * 100,
            ]);

            $this->playerGenerator->generateForTeam($team);

            return $team;
        });
    }

    public function updateTeam(Team $team, array $data): Team
    {
        $team->update([
            'name' => [
                'en' => $data['name']['en'],
                'ka' => $data['name']['ka'],
            ],
            'country' => [
                'en' => $data['country']['en'],
                'ka' => $data['country']['ka'],
            ],
        ]);

        return $team->fresh();
    }
}
