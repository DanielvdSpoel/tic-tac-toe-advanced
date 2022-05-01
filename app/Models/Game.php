<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'is_finished',
        'is_started',
        'playing_player_id',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(GamePosition::class);
    }

}
