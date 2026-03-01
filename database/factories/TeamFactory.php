<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        $country = CountryFactory::random();

        return [
            'user_id' => User::factory(),
            'name' => fake()->company() . ' FC',
            'country' => $country,
            'budget' => config('fantasy.team.initial_budget'),
        ];
    }
}
