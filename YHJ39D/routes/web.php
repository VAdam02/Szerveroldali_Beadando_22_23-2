<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\EventController;

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

Route::resource('games', GameController::class);
Route::get('/create', [GameController::class, 'create'])->name('create');
Route::get('/list', [GameController::class, 'list'])->name('list');

Route::post('/games/create', [GameController::class, 'createGame'])->name('createGame');
Route::post('/games/{game}/finish', [GameController::class, 'finish'])->name('games.finish');
Route::post('/games/{game}/edit', [GameController::class, 'editGame'])->name('games.edit');


Route::post('/events', [EventController::class, 'create'])->name('events.create');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

Auth::routes();
