<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdatePlayerRequest;
use App\Models\Player;
use App\Services\Api\PlayerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlayerController extends Controller
{
    use AuthorizesRequests;

    public function update(UpdatePlayerRequest $request, Player $player, PlayerService $service) 
    {
        $this->authorize('update', $player);

        $updatedPlayer = $service->updatePlayer(
            $player,
            $request->validated()
        );

        return response()->json([
            'message' => __('messages.player_updated'),
            'data' => $updatedPlayer
        ]);
    }
}
