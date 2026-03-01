<?php

namespace App\Services\Api;

use App\Models\Player;

class PlayerService
{
    public function updatePlayer(Player $player, array $data): Player
    {
        $player->update([
            'first_name' => [
                'en' => $data['first_name']['en'],
                'ka' => $data['first_name']['ka'],
            ],

            'last_name' => [
                'en' => $data['last_name']['en'],
                'ka' => $data['last_name']['ka'],
            ],

            'country' => [
                'en' => $data['country']['en'],
                'ka' => $data['country']['ka'],
            ],
        ]);

        return $player->fresh();
    }
}