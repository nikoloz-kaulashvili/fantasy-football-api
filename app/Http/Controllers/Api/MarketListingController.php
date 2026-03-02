<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateListingRequest;
use App\Http\Resources\Api\TransferListingResource;
use App\Http\Resources\Api\TransferResource;
use App\Models\TransferListing;
use App\Services\Api\TransferMarketService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MarketListingController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected TransferMarketService $market
    ) {}

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $cacheKey = "market.listings.page.{$page}";

        $listings = Cache::remember($cacheKey, 60, function () {
            return TransferListing::query()
                ->where('is_active', 1)
                ->with(['player', 'sellerTeam'])
                ->latest()
                ->paginate(20);
        });

        return TransferListingResource::collection($listings)
            ->additional([
                'success' => true,
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

        $listing->load(['player', 'sellerTeam']);

        return response()->json([
            'success' => true,
            'message' => __('messages.player_listed_successfully'),
            'data' => new TransferListingResource($listing),
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
        $transfer = $this->market->buyListing(
            $request->user(),
            $listing
        );

        $transfer->load([
            'player',
            'sellerTeam',
            'buyerTeam',
        ]);

        return response()->json([
            'success' => true,
            'message' => __('messages.transfer_completed_successfully'),
            'data' => new TransferResource($transfer),
        ], 200);
    }
}
