<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('game.index');
    }

    public function show(Game $game)
    {
        return view('game.show', ['game' => $game]);
    }

    
    public function list()
    {
        $current_time = Carbon::now();
        $activeGames = Game::where('finished', '=', false)->where('start', '<', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->get();
        $notActiveGames = Game::where('finished', '=', true)->orWhere('start', '>', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->paginate(10);

        foreach ($activeGames as $game)
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

        foreach ($notActiveGames as $game)
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

        return view('game.list', ['activeGames' => $activeGames, 'notActiveGames' => $notActiveGames]);
    }
}

?>