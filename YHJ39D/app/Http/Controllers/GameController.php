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
        $games = Game::with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->get();

        foreach ($games as $game)
        {
            $game->homeTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->home_team_id && $event->type == "goal"
                    || $event->player->team->id == $game->away_team_id && $event->type == "owngoal";
            })->count();

            $game->awayTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->away_team_id && $event->type == "goal"
                    || $event->player->team->id == $game->home_team_id && $event->type == "owngoal";
            })->count();
            
        }

        $activeGames = $games->filter(function ($game) {
            return $game->finished == false && $game->start < now();
        });
        $notActiveGames = $games->filter(function ($game) {
            return $game->finished == true || $game->start > now();
        });

        return view('game.games', ['activeGames' => $activeGames, 'notActiveGames' => $notActiveGames]);
    }
}

?>