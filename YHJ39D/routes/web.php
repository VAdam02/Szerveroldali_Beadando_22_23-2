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

Route::resource('games', GameController::class);
Route::get('/list', [GameController::class, 'list'])->name('list');

Route::post('/events', [EventController::class, 'create'])->name('events.create');

Auth::routes();

Route::get('/home', [GameController::class, 'index']);
