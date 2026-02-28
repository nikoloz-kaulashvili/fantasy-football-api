<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlayerPolicy
{
    /**
     * Allow listing only if the player belongs to the user's team.
     */
    public function listForSale(User $user, Player $player): Response
    {
        return $player->team->user_id === $user->id
            ? Response::allow()
            : Response::deny(__('messages.unauthorized'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Player $player): Response
    {
        return $player->team->user_id === $user->id
            ? Response::allow()
            : Response::deny(__('messages.unauthorized'));
    }
}
