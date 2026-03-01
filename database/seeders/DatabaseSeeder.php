<?php

use App\Jobs\GenerateTeamForUserJob;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()
            ->count(2)
            ->create();

        foreach ($users as $user) {
            GenerateTeamForUserJob::dispatch($user);
        }
    }
}