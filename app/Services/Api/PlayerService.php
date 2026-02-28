<?php

namespace App\Services\Api;

use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlayerService
{
    public function updatePlayer(User $user, Player $player, array $data): Player
    {
        if ($player->team->user_id !== $user->id) {

            Log::warning('Unauthorized player update attempt', [
                'user_id'   => $user->id,
                'player_id' => $player->id,
                'team_id'   => $player->team_id,
            ]);

            throw new HttpException(403, __('messages.unauthorized'));
        }

        $player->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'country'    => $data['country'],
        ]);

        return $player->fresh();
    }
}