<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransferResource;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function allTransfers()
    {
        $transfers = Transfer::query()
            ->with([
                'player',
                'sellerTeam',
                'buyerTeam',
            ])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => __('messages.transfers_fetched'),
            'data' => TransferResource::collection($transfers),
            'meta' => [
                'current_page' => $transfers->currentPage(),
                'last_page' => $transfers->lastPage(),
                'per_page' => $transfers->perPage(),
                'total' => $transfers->total(),
            ]
        ]);
    }

    public function myTransfers()
    {
        $team = auth()->user()->team;

        if (!$team) {
            return response()->json([
                'success' => false,
                'message' => __('messages.team_not_found')
            ], 404);
        }

        $transfers = Transfer::query()
            ->with(['player', 'sellerTeam', 'buyerTeam'])
            ->where(function ($query) use ($team) {
                $query->where('seller_team_id', $team->id)
                    ->orWhere('buyer_team_id', $team->id);
            })
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => __('messages.transfers_fetched'),
            'data' => TransferResource::collection($transfers->items()),
            'meta' => [
                'current_page' => $transfers->currentPage(),
                'last_page' => $transfers->lastPage(),
                'per_page' => $transfers->perPage(),
                'total' => $transfers->total(),
            ]
        ]);
    }
}
