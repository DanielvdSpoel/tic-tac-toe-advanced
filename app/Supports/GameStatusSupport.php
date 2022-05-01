<?php

namespace App\Supports;

class GameStatusSupport
{

    static function checkGameStatus($game)
    {
        //rows
        for ($x = 1; $x < 4; $x++) {
            $positions = $game->positions()->where('x', $x)->get();
            $colors = $positions->pluck('piece.player.color');
            if (count(array_unique($colors->toArray())) === 1 && $colors->first() !== null) {
                ray(array_unique($colors->toArray()));
                ray("Column win");
                return [
                    'finished' => true,
                    'status' => 'win',
                    'winner' => $colors->first(),
                ];
            }
        }

        //columns
        for ($x = 1; $x < 4; $x++) {
            $positions = $game->positions()->where('y', $x)->get();
            $colors = $positions->pluck('piece.player.color');
            if (count(array_unique($colors->toArray())) === 1 && $colors->first() !== null) {
                return [
                    'finished' => true,
                    'status' => 'win',
                    'winner' => $colors->first(),
                ];
            }
        }

        //diagonals
        $colors = collect([]);
        $piece1 = $game->positions()->where('x', 1)->where('y', 1)->first()->piece;
        $piece2 = $game->positions()->where('x', 2)->where('y', 2)->first()->piece;
        $piece3 = $game->positions()->where('x', 3)->where('y', 3)->first()->piece;

        $colors->push($piece1 ? $piece1->player->color : null);
        $colors->push($piece2 ? $piece2->player->color : null);
        $colors->push($piece3 ? $piece3->player->color : null);

        if (count(array_unique($colors->toArray())) === 1 && $colors->first() !== null) {
            return [
                'finished' => true,
                'status' => 'win',
                'winner' => $colors->first(),
            ];
        }

        $colors = collect([]);
        $piece1 = $game->positions()->where('x', 3)->where('y', 1)->first()->piece;
        $piece2 = $game->positions()->where('x', 2)->where('y', 2)->first()->piece;
        $piece3 = $game->positions()->where('x', 1)->where('y', 3)->first()->piece;

        $colors->push($piece1 ? $piece1->player->color : null);
        $colors->push($piece2 ? $piece2->player->color : null);
        $colors->push($piece3 ? $piece3->player->color : null);

        if (count(array_unique($colors->toArray())) === 1 && $colors->first() !== null) {
            return [
                'finished' => true,
                'status' => 'win',
                'winner' => $colors->first(),
            ];
        }

        //draw
        $firstPlayer = $game->players()->first();
        $secondPlayer = $game->players()->where('id', '!=', $firstPlayer->id)->first();

        if ($firstPlayer->availablePieces->count() === 0 && $secondPlayer->availablePieces->count() === 0) {
            return [
                'finished' => true,
                'status' => 'draw',
            ];
        }


        return [
            'finished' => false,
        ];

    }

}
