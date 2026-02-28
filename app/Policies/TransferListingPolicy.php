<?php

namespace App\Policies;

use App\Models\TransferListing;
use App\Models\User;

class TransferListingPolicy
{
    /**
     * Create listing (via player ownership)
     */
    public function create(User $user): bool
    {
        return $user->team !== null;
    }

    /**
     * Cancel listing
     */
    public function delete(User $user, TransferListing $listing): bool
    {
        return $listing->seller_team_id === $user->team?->id;
    }

}