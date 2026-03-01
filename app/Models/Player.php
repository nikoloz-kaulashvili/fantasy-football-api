<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use SoftDeletes, HasTranslations, HasFactory;

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

    public array $translatable = [
        'first_name',
        'last_name',
        'country',
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
