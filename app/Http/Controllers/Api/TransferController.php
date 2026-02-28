<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Illuminate\Http\Request;

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

        return response()->json($transfers);
    }

    public function myTransfers()
    {
        $teamId = auth()->user()->team->id;

        $transfers = Transfer::query()
            ->with([
                'player',
                'sellerTeam',
                'buyerTeam',
            ])
            ->where(function ($q) use ($teamId) {
                $q->where('seller_team_id', $teamId)
                  ->orWhere('buyer_team_id', $teamId);
            })
            ->latest()
            ->paginate(15);

        return response()->json($transfers);
    }
}
