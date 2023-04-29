<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Game;

class GameController extends Controller
{
    public function activeGames()
    {
        $current_time = Carbon::now();
        $activeGames = Game::where('finished', '=', false)->where('start', '<', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->get();
        foreach ($activeGames as $game)
        {
            $game->homeTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->home_team_id && $event->type == "gól"
                    || $event->player->team->id == $game->away_team_id && $event->type == "öngól";
            })->count();

            $game->awayTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->away_team_id && $event->type == "gól"
                    || $event->player->team->id == $game->home_team_id && $event->type == "öngól";
            })->count();
        }
        return $activeGames;
    }

    public function players(Game $game)
    {
        $players = $game->homeTeam->players->merge($game->awayTeam->players);
        return $players;
    }

    public function index()
    {
        $activeGames = $this->activeGames();

        return view('game.index', ['activeGames' => $activeGames]);
    }

    public function show(Game $game)
    {
        $activeGames = $this->activeGames();

        $game->load('homeTeam', 'awayTeam', 'events.player', 'events.player.team');
        $game->homeTeamScore = $game->events->filter(function ($event) use ($game) {
            return $event->player->team->id == $game->home_team_id && $event->type == "gól"
                || $event->player->team->id == $game->away_team_id && $event->type == "öngól";
        })->count();

        $game->awayTeamScore = $game->events->filter(function ($event) use ($game) {
            return $event->player->team->id == $game->away_team_id && $event->type == "gól"
                || $event->player->team->id == $game->home_team_id && $event->type == "öngól";
        })->count();

        return view('game.show', ['games' => $this, 'game' => $game, 'activeGames' => $activeGames]);
    }

    public function finish(Game $game)
    {
        if (!(Auth::check() && Auth::user()->can('finish', $game)))
        {
            Session::flash('error', 'Nincs jogosultságod a mérkőzés lezárásához');
            return redirect()->route('games.show', ['game' => $game]);
        }

        if ($game->finished)
        {
            Session::flash('error', 'A mérkőzés már lezárásra került');
            return redirect()->route('games.show', ['game' => $game]);
        }

        $game->finished = true;
        $game->save();
        Session::flash('success', 'A mérkőzés sikeresen lezárva');
        return redirect()->route('games.show', ['game' => $game]);
    }
    
    public function list()
    {
        $current_time = Carbon::now();
        $activeGames = $this->activeGames();
        $notActiveGames = Game::where('finished', '=', true)->orWhere('start', '>', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->paginate(10);

        foreach ($notActiveGames as $game)
        {
            $game->homeTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->home_team_id && $event->type == "gól"
                    || $event->player->team->id == $game->away_team_id && $event->type == "öngól";
            })->count();

            $game->awayTeamScore = $game->events->filter(function ($event) use ($game) {
                return $event->player->team->id == $game->away_team_id && $event->type == "gól"
                    || $event->player->team->id == $game->home_team_id && $event->type == "öngól";
            })->count();
        }

        return view('game.list', ['activeGames' => $activeGames, 'notActiveGames' => $notActiveGames]);
    }
}

?>