<?php

namespace App\Providers;

use App\Models\Player;
use App\Models\Team;
use App\Models\TransferListing;
use App\Policies\TeamPolicy;
use App\Policies\PlayerPolicy;
use App\Policies\TransferListingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Team::class   => TeamPolicy::class,
        Player::class => PlayerPolicy::class,
        TransferListing::class => TransferListingPolicy::class,

    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
