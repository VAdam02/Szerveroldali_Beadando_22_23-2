<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GameController;
use App\Models\Team;

class TeamController extends Controller
{
    public function list()
    {
        $teams = Team::orderBy('name')->paginate(10);
        return view('team.list', ['teams' => $teams, 'activeGames' => app(GameController::class)->activeGames()]);
    }

    public function show(Team $team)
    {
        $team->load('gameAsHome', 'gameAsAway', 'gameAsHome.events', 'gameAsAway.events', 'players', 'players.events');
        $team->games = $team->gameAsHome->merge($team->gameAsAway);
        
        for ($i = 0; $i < count($team->games); $i++)
        {
            $team->games[$i] = app(GameController::class)->getScore($team->games[$i]);
        }

        return view('team.show', ['team' => $team, 'activeGames' => app(GameController::class)->activeGames()]);
    }
}
?>