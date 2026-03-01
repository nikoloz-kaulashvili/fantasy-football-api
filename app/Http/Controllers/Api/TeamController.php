<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SwapPlayersRequest;
use App\Http\Requests\Api\UpdateTeamRequest;
use App\Http\Resources\Api\TeamResource;
use App\Services\Api\PlayerService;
use App\Services\Api\TeamService;
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

        return new TeamResource($team);
    }

    public function update(UpdateTeamRequest $request, TeamService $service)
    {
        $user = auth()->user();
        $team = $user->team;

        if (!$team) {
            return response()->json([
                'message' => __('messages.team_not_found')
            ], 404);
        }

        $this->authorize('update', $team);

        $team = $service->updateTeam($team, $request->validated());

        return response()->json([
            'success' => true,
            'message' => __('messages.team_updated'),
            'data' => new TeamResource($team),
        ], 200);
    }

    public function swap(SwapPlayersRequest $request, PlayerService $service)
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
