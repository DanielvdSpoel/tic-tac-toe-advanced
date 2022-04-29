<?php

use App\Events\GameUpdatedEvent;
use App\Http\Controllers\GameController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/{game}', function (Game $game) {
    GameUpdatedEvent::dispatch($game);
});
Route::get('/games/{game}/join', [GameController::class, 'showJoin'])->name('games.join');
Route::post('/games/{game}/join', [GameController::class, 'join'])->name('games.join');

Route::resource('games', GameController::class);

Route::redirect('/', \route('games.create'));
