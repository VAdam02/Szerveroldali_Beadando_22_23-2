<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Team;

class GameController extends Controller
{
    public function getScore(Game $game)
    {
        $game->load('homeTeam', 'awayTeam', 'events.player', 'events.player.team');
        $game->homeTeamScore = $game->events->filter(function ($event) use ($game) {
            return $event->player->team->id == $game->home_team_id && $event->type == "gól"
                || $event->player->team->id == $game->away_team_id && $event->type == "öngól";
        })->count();

        $game->awayTeamScore = $game->events->filter(function ($event) use ($game) {
            return $event->player->team->id == $game->away_team_id && $event->type == "gól"
                || $event->player->team->id == $game->home_team_id && $event->type == "öngól";
        })->count();

        return $game;
    }

    public function activeGames()
    {
        $current_time = Carbon::now();
        $activeGames = Game::where('finished', '=', false)->where('start', '<', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->get();
        for ($i = 0; $i < count($activeGames); $i++)
        {
            $activeGames[$i] = $this->getScore($activeGames[$i]);
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

        return view('index', ['activeGames' => $activeGames]);
    }

    public function show(Game $game)
    {
        $activeGames = $this->activeGames();
        $game = $this->getScore($game);
        return view('game.show', ['games' => $this, 'game' => $game, 'activeGames' => $activeGames]);
    }

    public function create()
    {
        if (!(Auth::check() && Auth::user()->can('create', Game::class)))
        {
            Session::flash('error', 'Nincs jogosultságod új mérkőzés létrehozásához');
            return redirect()->route('home');
        }

        return view('game.create', ['teams' => Team::all(), 'activeGames' => $this->activeGames()]);
    }
    
    public function list()
    {
        $current_time = Carbon::now();
        $activeGames = $this->activeGames();
        $notActiveGames = Game::where('finished', '=', true)->orWhere('start', '>', $current_time)->with('homeTeam', 'awayTeam', 'events.player', 'events.player.team')->orderByDesc('start')->paginate(10);
        for ($i = 0; $i < count($notActiveGames); $i++)
        {
            $notActiveGames[$i] = $this->getScore($notActiveGames[$i]);
        }
        return view('game.list', ['activeGames' => $activeGames, 'notActiveGames' => $notActiveGames]);
    }

    public function edit(Game $game)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $game)))
        {
            Session::flash('error', 'Nincs jogosultságod a mérkőzés szerkesztéséhez');
            return redirect()->route('games.show', ['game' => $game]);
        }

        return view('game.edit', ['game' => $game, 'teams' => Team::all(), 'activeGames' => $this->activeGames()]);
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

    public function createGame(Request $request)
    {   
        if (!(Auth::check() && Auth::user()->can('create', Game::class)))
        {
            Session::flash('error', 'Nincs jogosultságod új mérkőzés létrehozásához');
            return redirect()->route('home');
        }

        $request->validate([
            'home_team_id' => 'required|integer|exists:teams,id',
            'away_team_id' => 'required|integer|exists:teams,id|different:home_team_id',
            'start' => 'required|date|after:now',
        ],
        [
            'home_team_id.required' => 'A hazai csapat kiválasztása kötelező',
            'home_team_id.integer' => 'Nem megfelelő formátum',
            'home_team_id.exists' => 'Nincs ilyen csapat',
            'away_team_id.required' => 'A vendég csapat kiválasztása kötelező',
            'away_team_id.integer' => 'Nem megfelelő formátum',
            'away_team_id.exists' => 'Nincs ilyen csapat',
            'away_team_id.different' => 'A két csapat nem lehet azonos',
            'start.required' => 'A kezdési időpont kiválasztása kötelező',
            'start.date' => 'Nem megfelelő formátum',
            'start.after' => 'A kezdési időpont nem lehet múlt'
        ]);

        $game = new Game();
        $game->home_team_id = $request->home_team_id;
        $game->away_team_id = $request->away_team_id;
        $game->start = date('Y-m-d H:i:s', strtotime($request->start));
        $game->save();
        Session::flash('success', 'A mérkőzés sikeresen létrehozva');
        return redirect()->route('games.show', ['game' => $game]);
    }

    public function editGame(Request $request, Game $game)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $game)))
        {
            Session::flash('error', 'Nincs jogosultságod a mérkőzés szerkesztéséhez');
            return redirect()->route('games.show', ['game' => $game]);
        }

        $request->validate([
            'home_team_id' => 'required|integer|exists:teams,id',
            'away_team_id' => 'required|integer|exists:teams,id|different:home_team_id',
            'start' => 'required|date|after:now',
        ],
        [
            'home_team_id.required' => 'A hazai csapat kiválasztása kötelező',
            'home_team_id.integer' => 'Nem megfelelő formátum',
            'home_team_id.exists' => 'Nincs ilyen csapat',
            'away_team_id.required' => 'A vendég csapat kiválasztása kötelező',
            'away_team_id.integer' => 'Nem megfelelő formátum',
            'away_team_id.exists' => 'Nincs ilyen csapat',
            'away_team_id.different' => 'A két csapat nem lehet azonos',
            'start.required' => 'A kezdési időpont kiválasztása kötelező',
            'start.date' => 'Nem megfelelő formátum',
            'start.after' => 'A kezdési időpont nem lehet múlt'
        ]);

        $game->home_team_id = $request->home_team_id;
        $game->away_team_id = $request->away_team_id;
        $game->start = date('Y-m-d H:i:s', strtotime($request->start));
        $game->save();
        Session::flash('success', 'A mérkőzés sikeresen szerkesztve');
        return redirect()->route('games.show', ['game' => $game]);
    }

    public function destroy(Game $game)
    {
        if (!(Auth::check() && Auth::user()->can('delete', $game)))
        {
            Session::flash('error', 'Nincs jogosultságod a mérkőzés törléséhez');
            return redirect()->route('games.show', ['game' => $game]);
        }

        $game->delete();
        Session::flash('success', 'A mérkőzés sikeresen törölve');
        return redirect()->route('games.list');
    }
}

?>