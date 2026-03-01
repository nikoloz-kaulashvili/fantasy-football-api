<?php

use App\Models\User;
use App\Services\Api\TeamService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        protected TeamService $teamService
    ) {}

    public function run(): void
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            $this->teamService->createForUser($user);
        }
    }
}