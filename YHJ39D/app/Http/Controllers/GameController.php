<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('game.index');
    }

    public function games()
    {
        $games = Game::all();
        //$games = [];
        return view('game.games', ['games' => $games]);
    }
}

?>