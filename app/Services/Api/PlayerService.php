<?php

namespace App\Services\Api;

use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlayerService
{
    public function updatePlayer(Player $player, array $data): Player
    {
        $player->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'country'    => $data['country'],
        ]);

        return $player->fresh();
    }
}