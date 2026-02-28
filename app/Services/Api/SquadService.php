<?php

namespace App\Services\Api;

use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SquadService
{
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

        DB::transaction(function () use ($in, $out) {

            $in->update(['squad_role' => 'starter']);
            $out->update(['squad_role' => 'bench']);

        });
    }
}