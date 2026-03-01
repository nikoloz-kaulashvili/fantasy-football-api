<?php

namespace App\Support\Factories;

class LastNameFactory
{
    public static function random(): array
    {
        $lastNames = config('last_names');
        $lastName = $lastNames[array_rand($lastNames)];
        
        return [
            'en' => $lastName['en'],
            'ka' => $lastName['ka'],
        ];
    }
}