<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    use HasFactory, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'color',
    ];

    protected $appends = ['availablePieces'];

    public function getAvailablePiecesAttribute(): Collection
    {
        return $this->pieces()->whereNull('game_position_id')->get();
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function pieces(): HasMany
    {
        return $this->HasMany(GamePiece::class);
    }

}
