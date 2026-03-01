<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdatePlayerRequest;
use App\Http\Resources\Api\PlayerResource;
use App\Models\Player;
use App\Services\Api\PlayerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlayerController extends Controller
{
    use AuthorizesRequests;

    public function update(
        UpdatePlayerRequest $request,
        Player $player,
        PlayerService $service
    ) {
        $this->authorize('update', $player);

        $updatedPlayer = $service->updatePlayer(
            $player,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => __('messages.player_updated'),
            'data' => new PlayerResource($updatedPlayer),
        ], 200);
    }
}
