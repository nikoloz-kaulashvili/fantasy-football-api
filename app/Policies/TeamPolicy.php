<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): Response
    {
        return $team->user_id === $user->id
            ? Response::allow()
            : Response::deny(__('messages.unauthorized'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): Response
    {
        return $team->user_id === $user->id
            ? Response::allow()
            : Response::deny(__('messages.unauthorized'));
    }

}
