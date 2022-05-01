<?php

namespace App\Http\Controllers;

use App\Events\GameFinishedEvent;
use App\Events\GameUpdatedEvent;
use App\Http\Requests\UpdateGamePositionRequest;
use App\Models\GamePiece;
use App\Models\GamePosition;
use App\Supports\GameStatusSupport;
use Illuminate\Http\Request;

class GamePositionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGamePositionRequest $request
     * @param \App\Models\GamePosition $gamePosition
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGamePositionRequest $request, GamePosition $gamePosition)
    {
        $data = $request->validated();
        $gamePiece = GamePiece::find($data['piece_id']);

        if ($gamePosition->piece) {
            if ($gamePosition->piece->value >= $gamePiece->value) {
                return redirect()->route('games.show', $gamePosition->game);
            }

            $gamePosition->piece()->update([
                'game_position_id' => null,
                'deleted' => true,
            ]);
        }

        $gamePiece->update([
            'game_position_id' => $gamePosition->id,
        ]);

        $game = $gamePosition->game;

        $result = GameStatusSupport::checkGameStatus($game);
        if($result['finished']) {
            $game->is_finished = true;
            GameFinishedEvent::dispatch($game, $result['status'], $result['winner']);

        } else {
            $game->update([
                'playing_player_id' => $game->players()->where('id', '!=', $game->playing_player_id)->first()->id,
            ]);

            GameUpdatedEvent::dispatch($game);
        }

        return redirect()->route('games.show', $game);
    }


}
