<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferListing extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'player_id',
        'seller_team_id',
        'price',
        'is_active',
        'sold_at',
    ];

    protected $casts = [
        'is_active' => 'integer', // 1/0
        'sold_at' => 'datetime',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function sellerTeam()
    {
        return $this->belongsTo(Team::class, 'seller_team_id');
    }
}