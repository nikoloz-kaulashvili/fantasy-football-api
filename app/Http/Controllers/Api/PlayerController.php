<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdatePlayerRequest;
use App\Models\Player;
use App\Services\Api\PlayerService;

class PlayerController extends Controller
{
    public function update(UpdatePlayerRequest $request, Player $player, PlayerService $service)
    {
        $updatedPlayer = $service->updatePlayer(
            auth()->user(),
            $player,
            $request->validated()
        );

        return response()->json([
            'message' => __('messages.player_updated'),
            'data' => $updatedPlayer
        ]);
    }
}
