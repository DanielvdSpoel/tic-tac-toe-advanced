<?php

namespace App\Http\Controllers;

use App\Events\GameStartedEvent;
use App\Http\Requests\JoinGameRequest;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    /**
     * Create a new game
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGameRequest $request)
    {
        $game = Game::create([]);
        $player = $game->players()->create($request->validated());
        Auth::login($player);

        return redirect()->route('games.show', $game);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Game $game
     * @return Response
     */
    public function show(Game $game)
    {
        if (!$game->is_started) {
            return Inertia::render('Waiting', [
                'game' => $game
            ]);
        } else {
            return Inertia::render('Play', [
                'game' => $game
            ]);
        }
    }

    public function showJoin(Game $game)
    {
        if ($game->players()->count() >= 2) {
            dd("Game zit al vol!");
        }
        if ($game->is_started) {
            dd("Game is al gestart");
            //return redirect()->route('games.show', $game);
        }
        return Inertia::render('Join', [
            'game' => $game
        ]);
    }

    public function join(JoinGameRequest $request, Game $game)
    {
        $data = $request->validated();
        $player = $game->players()->create([
            'name' => $data['name'],
            'color' => $game->players()->first()->color¶ === 'red' ? 'blue' : 'red'
        ]);
        Auth::login($player);

        $game->update([
            'is_started' => true,
            'playing_player_id' => $player->id,
        ]);

        GameStartedEvent::dispatch($game);

        return redirect()->route('games.show', $game);

    }
}
