<?php

namespace Database\Factories;

use App\Models\Team;
use App\Support\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    public function definition(): array
    {
        $country = CountryFactory::random();

        return [
            'team_id' => Team::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'country_en' => $country['en'],
            'country_ka' => $country['ka'],
            'age' => rand(18, 40),
            'position' => fake()->randomElement(['GK', 'DF', 'MF', 'FW']),
            'market_value' => 1000000 * 100,
        ];
    }
}