<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [GameController::class, 'index'])->name('home');
Route::get('/home', [GameController::class, 'index']);

Route::get('/games/list', [GameController::class, 'list'])->name('games.list');
Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
Route::post('/games/create', [GameController::class, 'createGame'])->name('game.create');
Route::get('/games/{game}/show', [GameController::class, 'show'])->name('games.show');
Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
Route::post('/games/{game}/edit', [GameController::class, 'editGame'])->name('games.edit');
Route::post('/games/{game}/finish', [GameController::class, 'finish'])->name('games.finish');
Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

Route::post('/events/create', [EventController::class, 'create'])->name('events.create');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

Route::get('/teams/list', [TeamController::class, 'list'])->name('teams.list');
Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::post('/teams/create', [TeamController::class, 'createTeam'])->name('teams.create');
Route::get('/teams/{team}/show', [TeamController::class, 'show'])->name('teams.show');
Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
Route::post('/teams/{team}/edit', [TeamController::class, 'editTeam'])->name('teams.edit');
Route::post('/teams/{team}/addPlayer', [TeamController::class, 'addPlayer'])->name('teams.addPlayer');
Route::delete('/teams/{team}/{player}', [TeamController::class, 'destroyPlayer'])->name('teams.destroyPlayer');
Route::get('/teams/tabella', [TeamController::class, 'tabella'])->name('teams.tabella');

Auth::routes();
