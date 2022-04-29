<?php

namespace App\Listeners;

use App\Events\GameStartedEvent;
use App\Events\GameUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateGamePositions
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GameStartedEvent  $event
     * @return void
     */
    public function handle(GameStartedEvent $event)
    {
        $game = $event->game;
        for ($x = 1; $x < 4; $x++){
            for ($y = 1; $y < 4; $y++){
                $game->positions()->create([
                    'x' => $x,
                    'y' => $y
                ]);
            }
        }
        $pieces = [1, 1, 2, 2, 3, 3];
        foreach ($game->players as $player) {
            foreach ($pieces as $piece) {
                $player->pieces()->create([
                    'value' => $piece
                ]);
            }
        }

        GameUpdatedEvent::dispatch($game);
    }
}
