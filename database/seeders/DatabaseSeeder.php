<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Api\TeamService;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@fantasy.ge'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
            ]
        );

        app(TeamService::class)->createForUser($user);
    }
}