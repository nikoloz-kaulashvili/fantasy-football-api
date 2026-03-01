<?php

namespace App\Support\Factories;

class LastNameFactory
{
    public static function random(): array
    {
        $names = config('last_names');

        $name = $names[array_rand($names)];

        return [
            'en' => $name['en'],
            'ka' => $name['ka'],
        ];
    }
}