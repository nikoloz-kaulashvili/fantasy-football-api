<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateListingRequest;
use App\Http\Requests\Api\BuyListingRequest;
use App\Models\TransferListing;
use App\Services\Api\TransferMarketService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MarketListingController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected TransferMarketService $market
    ) {}

    public function index(Request $request)
    {
        $query = TransferListing::query()
            ->where('is_active', 1)
            ->with(['player', 'sellerTeam']);

        return response()->json([
            'data' => $query->latest()->paginate(20),
        ]);
    }

    public function store(CreateListingRequest $request)
    {
        $this->authorize('create', TransferListing::class);

        $listing = $this->market->createListing(
            $request->user(),
            $request->player_id,
            $request->price
        );

        return response()->json([
            'message' => __('messages.player_listed_successfully'),
            'data' => $listing->load(['player', 'sellerTeam']),
        ], 201);
    }

    public function destroy(Request $request, TransferListing $listing)
    {
        $this->authorize('delete', $listing);

        $this->market->cancelListing($request->user(), $listing);

        return response()->json([
            'message' => __('messages.listing_cancelled_successfully'),
        ]);
    }

    public function buy(Request $request, TransferListing $listing)
    {
        $transfer = $this->market->buyListing($request->user(), $listing);

        return response()->json([
            'message' => __('messages.transfer_completed_successfully'),
            'data' => $transfer,
        ]);
    }
}