<?php

namespace App\Support\Factories;

class FirstNameFactory
{
    public static function random(): array
    {
        $names = config('first_names');

        $name = $names[array_rand($names)];

        return [
            'en' => $name['en'],
            'ka' => $name['ka'],
        ];
    }
}