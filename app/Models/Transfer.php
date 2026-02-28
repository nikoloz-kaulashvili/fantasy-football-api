<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'player_id',
        'seller_team_id',
        'buyer_team_id',
        'transfer_listing_id',
        'price',
        'market_value_before',
        'market_value_after',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function sellerTeam()
    {
        return $this->belongsTo(Team::class, 'seller_team_id');
    }

    public function buyerTeam()
    {
        return $this->belongsTo(Team::class, 'buyer_team_id');
    }

    public function listing()
    {
        return $this->belongsTo(TransferListing::class, 'transfer_listing_id');
    }
}