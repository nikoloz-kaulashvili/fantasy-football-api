<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SwapPlayersRequest;
use App\Http\Requests\Api\UpdateTeamRequest;
use App\Services\Api\SquadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TeamController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request)
    {
        $team = $request->user()
            ->team()
            ->with(['starters', 'bench'])
            ->first();

        $this->authorize('view', $team);

        return response()->json([
            'id' => $team->id,
            'name' => $team->name,
            'country' => $team->country,
            'budget' => $team->budget,
            'total_value' => $team->total_value,
            'players' => [
                'starters' => $team->starters,
                'bench' => $team->bench,
            ],
        ]);
    }

    public function update(UpdateTeamRequest $request)
    {
        $user = auth()->user();

        $team = $user->team;

        if (!$team) {
            return response()->json([
                'message' => __('messages.team_not_found')
            ], 404);
        }

        $this->authorize('update', $team);

        $team->update([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return response()->json([
            'message' => __('messages.team_updated'),
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
                'country' => $team->country,
                'budget' => $team->budget,
                'total_value' => $team->total_value,
            ]
        ]);
    }

    public function swap(SwapPlayersRequest $request, SquadService $service)
    {
        $team = auth()->user()->team;

        if (!$team) {
            return response()->json([
                'message' => __('messages.team_not_found')
            ], 404);
        }

        $this->authorize('update', $team);

        $in = $team->players()->findOrFail($request->in_player_id);
        $out = $team->players()->findOrFail($request->out_player_id);

        $service->swapPlayers($in, $out);

        return response()->json([
            'message' => __('messages.swap_success')
        ]);
    }
}
