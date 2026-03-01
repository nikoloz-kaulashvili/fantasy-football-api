<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Api\TeamService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTeamForUserJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public User $user) {}

    public function handle(TeamService $teamService): void
    {
        if ($this->user->team()->exists()) {
            return;
        }

        $teamService->createForUser($this->user);
    }
}
