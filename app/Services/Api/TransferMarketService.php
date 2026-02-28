<?php

namespace App\Services\Api;

use App\Models\Player;
use App\Models\Team;
use App\Models\Transfer;
use App\Models\TransferListing;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferMarketService
{
    public function createListing(User $user, int $playerId, int $price): TransferListing
    {
        return DB::transaction(function () use ($user, $playerId, $price) {

            $team = Team::where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $player = Player::where('id', $playerId)
                ->where('team_id', $team->id)
                ->lockForUpdate()
                ->firstOrFail();

            $alreadyListed = TransferListing::where('player_id', $player->id)
                ->where('is_active', 1)
                ->lockForUpdate()
                ->exists();

            if ($alreadyListed) {
                throw ValidationException::withMessages([
                    'player_id' => [__('validation.player_already_listed')],
                ]);
            }

            return TransferListing::create([
                'player_id' => $player->id,
                'seller_team_id' => $team->id,
                'price' => $price,
                'is_active' => 1,
            ]);
        });
    }

    public function cancelListing(User $user, TransferListing $listing): void
    {
        DB::transaction(function () use ($user, $listing) {

            $team = Team::where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedListing = TransferListing::where('id', $listing->id)
                ->where('is_active', 1)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $lockedListing->seller_team_id !== (int) $team->id) {
                throw ValidationException::withMessages([
                    'listing' => [__('validation.not_owner')],
                ]);
            }

            $lockedListing->update([
                'is_active' => 0,
            ]);
        });
    }

    public function buyListing(User $user, TransferListing $listing)
    {
        return DB::transaction(function () use ($user, $listing) {

            $buyerTeam = Team::where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedListing = TransferListing::where('id', $listing->id)
                ->where('is_active', 1)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $lockedListing->seller_team_id === (int) $buyerTeam->id) {
                throw ValidationException::withMessages([
                    'listing' => [__('validation.cannot_buy_own_player')],
                ]);
            }

            $sellerTeam = Team::where('id', $lockedListing->seller_team_id)
                ->lockForUpdate()
                ->firstOrFail();

            $player = Player::where('id', $lockedListing->player_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $player->team_id !== (int) $sellerTeam->id) {
                throw ValidationException::withMessages([
                    'listing' => [__('validation.listing_invalid')],
                ]);
            }

            if ((int) $buyerTeam->budget < (int) $lockedListing->price) {
                throw ValidationException::withMessages([
                    'budget' => [__('validation.insufficient_budget')],
                ]);
            }

            $marketBefore = (int) $player->market_value;

            // +10%..+100%
            $percent = random_int(10, 100);
            $marketAfter = (int) round($marketBefore * (1 + ($percent / 100)));

            // budgets
            $buyerTeam->decrement('budget', $lockedListing->price);
            $sellerTeam->increment('budget', $lockedListing->price);

            // transfer player
            $player->update([
                'team_id' => $buyerTeam->id,
                'market_value' => $marketAfter,
            ]);

            // close listing
            $lockedListing->update([
                'is_active' => 0,
                'sold_at' => now(),
            ]);

            // history
            return Transfer::create([
                'player_id' => $player->id,
                'seller_team_id' => $sellerTeam->id,
                'buyer_team_id' => $buyerTeam->id,
                'transfer_listing_id' => $lockedListing->id,
                'price' => (int) $lockedListing->price,
                'market_value_before' => $marketBefore,
                'market_value_after' => $marketAfter,
            ]);
        });
    }
}
