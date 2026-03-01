<?php

namespace App\Support\Factories;

class CountryFactory
{
    public static function random(): array
    {
        $countries = config('countries');

        $country = $countries[array_rand($countries)];

        return [
            'en' => $country['en'],
            'ka' => $country['ka'],
        ];
    }
}