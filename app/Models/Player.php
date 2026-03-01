<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'first_name',
        'last_name',
        'country',
        'age',
        'position',
        'market_value',
        'squad_role'
    ];

    protected $casts = [
        'first_name' => 'array',
        'last_name'  => 'array',
        'country'    => 'array',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function listing()
    {
        return $this->hasOne(TransferListing::class);
    }

    protected static function booted()
    {
        static::deleting(function (Player $player) {
            if ($player->isForceDeleting()) {
                $player->listing()?->forceDelete();
            } else {
                $player->listing()?->delete();
            }
        });
    }
}
