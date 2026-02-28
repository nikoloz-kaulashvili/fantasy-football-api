<?php

namespace App\Services\Api;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                'name' => $user->name . "'s Team",
                'country' => fake()->country(),
                'budget' => 5000000 * 100,
            ]);

            $this->playerGenerator->generateForTeam($team);

            return $team;
        });
    }
}