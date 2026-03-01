<?php

namespace App\Services\Api;

use App\Models\Player;
use Illuminate\Validation\ValidationException;

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

    public function swapPlayers(Player $in, Player $out): void
    {
        if ($in->id === $out->id) {
            throw ValidationException::withMessages([
                'players' => __('messages.same_player_swap')
            ]);
        }

        if ($in->team_id !== $out->team_id) {
            throw ValidationException::withMessages([
                'team' => __('messages.players_not_same_team')
            ]);
        }

        if ($in->squad_role !== 'bench') {
            throw ValidationException::withMessages([
                'in_player' => __('messages.player_must_be_bench')
            ]);
        }

        if ($out->squad_role !== 'starter') {
            throw ValidationException::withMessages([
                'out_player' => __('messages.player_must_be_starter')
            ]);
        }

        if ($in->position === 'GK' && $out->position !== 'GK') {
            throw ValidationException::withMessages([
                'goalkeeper' => __('messages.goalkeeper_can_only_swap_with_goalkeeper')
            ]);
        }

        DB::transaction(function () use ($in, $out) {

            $in->update(['squad_role' => 'starter']);
            $out->update(['squad_role' => 'bench']);
        });
    }
}
