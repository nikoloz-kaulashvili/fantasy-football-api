<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Team extends Model
{
    use SoftDeletes, HasTranslations;

    protected $fillable = [
        'user_id',
        'name',
        'country',
        'budget',
    ];

    public array $translatable = [
        'name',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function listings()
    {
        return $this->hasMany(TransferListing::class, 'seller_team_id');
    }

    public function getTotalValueAttribute(): int
    {
        return (int) $this->players()->sum('market_value');
    }

    public function starters()
    {
        return $this->hasMany(Player::class)
            ->where('squad_role', 'starter');
    }

    public function bench()
    {
        return $this->hasMany(Player::class)
            ->where('squad_role', 'bench');
    }
}
