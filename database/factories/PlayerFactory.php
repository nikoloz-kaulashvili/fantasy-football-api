<?php

namespace Database\Factories;

use App\Models\Team;
use App\Support\Factories\CountryFactory;
use App\Support\Factories\FirstNameFactory;
use App\Support\Factories\LastNameFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'first_name'   => FirstNameFactory::random(),
            'last_name'    => LastNameFactory::random(),
            'country'      => CountryFactory::random(),
            'age' => rand(18, 40),
            'position' => fake()->randomElement(['GK', 'DF', 'MF', 'FW']),
            'market_value' => 1000000,
        ];
    }
}
