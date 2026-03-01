<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company() . ' FC',
            'country' => CountryFactory::random(),
            'budget' => config('fantasy.team.initial_budget'),
        ];
    }
}
