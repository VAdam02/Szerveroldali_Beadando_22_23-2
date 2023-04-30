<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;

class TeamController extends Controller
{
    public function list()
    {
        $teams = Team::orderBy('name')->paginate(10);
        return view('team.list', ['teams' => $teams, 'activeGames' => app(GameController::class)->activeGames()]);
    }

    public function show(Team $team)
    {
        $team->load('players.events');

        $team->games = $team->gameAsHome->merge($team->gameAsAway);

        for ($i = 0; $i < count($team->games); $i++)
        {
            $team->games[$i] = app(GameController::class)->getScore($team->games[$i]);
        }

        for ($i = 0; $i < count($team->players); $i++)
        {
            $team->players[$i]->owngoals = $team->players[$i]->events->filter(function ($event) use ($team) {
                return $event->type == "öngól" && $event->player->team->id == $team->id;
            })->count();
            $team->players[$i]->goals = $team->players[$i]->events->filter(function ($event) use ($team) {
                return $event->type == "gól" && $event->player->team->id == $team->id;
            })->count();
            $team->players[$i]->yellowCards = $team->players[$i]->events->filter(function ($event) use ($team) {
                return $event->type == "sárga lap" && $event->player->team->id == $team->id;
            })->count();
            $team->players[$i]->redCards = $team->players[$i]->events->filter(function ($event) use ($team) {
                return $event->type == "piros lap" && $event->player->team->id == $team->id;
            })->count();
        }

        return view('team.show', ['team' => $team, 'activeGames' => app(GameController::class)->activeGames()]);
    }

    public function create()
    {
        if (!(Auth::check() && Auth::user()->can('create', Team::class)))
        {
            Session::flash('error', 'Nincs jogosultságod új csapat létrehozásához');
            return redirect()->route('teams.list');
        }

        return view('team.create', ['activeGames' => app(GameController::class)->activeGames()]);
    }

    public function edit(Team $team)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $team)))
        {
            Session::flash('error', 'Nincs jogosultságod csapat szerkesztéséhez');
            return redirect()->route('teams.show', ['team' => $team]);
        }

        return view('team.edit', ['team' => $team, 'activeGames' => app(GameController::class)->activeGames()]);
    }

    public function tabella()
    {
        $teams = Team::all()->load('gameAsHome', 'gameAsAway');

        for ($i = 0; $i < count($teams); $i++)
        {
            $teams[$i]->games = $teams[$i]->gameAsHome->merge($teams[$i]->gameAsAway);
            
            $wins = 0;
            $draws = 0;

            $goalGet = 0;
            $goalMake = 0;

            foreach ($teams[$i]->games as $game)
            {
                $game = app(GameController::class)->getScore($game);

                if ($game->start > now()) { continue; }
                
                if ($game->home_team_id == $teams[$i]->id)
                {
                    if ($game->homeTeamScore > $game->awayTeamScore) { $wins++; }
                    else if ($game->homeTeamScore == $game->awayTeamScore) { $draws++; }
                    $goalMake += $game->homeTeamScore;
                    $goalGet += $game->awayTeamScore;
                }
                else
                {
                    if ($game->homeTeamScore < $game->awayTeamScore) { $wins++; }
                    else if ($game->homeTeamScore == $game->awayTeamScore) { $draws++; }
                    $goalMake += $game->awayTeamScore;
                    $goalGet += $game->homeTeamScore;
                }
            }

            $teams[$i]->points = $wins * 3 + $draws;
            $teams[$i]->goalDif = $goalMake - $goalGet;
        }

        $teams = $teams->sortBy('name')->sortByDesc('goalDif')->sortByDesc('points');
    

        return view('team.tabella', ['teams' => $teams, 'activeGames' => app(GameController::class)->activeGames()]);
    }





    public function createTeam(Request $request)
    {
        if (!(Auth::check() && Auth::user()->can('create', Team::class)))
        {
            Session::flash('error', 'Nincs jogosultságod új csapat létrehozásához');
            return redirect()->route('teams.list');
        }

        $request->validate([
            'name' => 'required|unique:teams|max:255',
            'shortname' => 'required|unique:teams|min:4|max:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ],
        [
            'name.required' => 'A csapat nevének megadása kötelező',
            'name.unique' => 'A csapat neve már foglalt',
            'name.max' => 'A csapat neve túl hosszú',
            'shortname.required' => 'A csapat rövid nevének megadása kötelező',
            'shortname.unique' => 'A csapat rövid neve már foglalt',
            'shortname.min' => 'A csapat rövid neve 4 karakter hosszú kell legyen',
            'shortname.max' => 'A csapat rövid neve 4 karakter hosszú kell legyen',
            'image.image' => 'A csapat logója csak kép lehet',
            'image.mimes' => 'A csapat logója csak jpg, jpeg, png, gif vagy svg lehet',
            'image.max' => 'A csapat logója túl nagy'
        ]);

        $team = new Team();
        $team->name = $request->name;
        $team->shortname = $request->shortname;
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fname = $file->hashName();
            Storage::disk('public')->put('images/' . $fname, $file->get());
            $team->image = $fname;
        }
        $team->save();

        Session::flash('success', 'A csapat sikeresen létrehozva');
        return redirect()->route('teams.show', ['team' => $team]);
    }

    public function editTeam(Request $request, Team $team)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $team)))
        {
            Session::flash('error', 'Nincs jogosultságod csapat szerkesztéséhez');
            return redirect()->route('teams.show', ['team' => $team]);
        }

        $request->validate([
            'name' => 'required|unique:teams,name,' . $team->id . '|max:255',
            'shortname' => 'required|unique:teams,shortname,' . $team->id . '|min:4|max:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ],
        [
            'name.required' => 'A csapat nevének megadása kötelező',
            'name.unique' => 'A csapat neve már foglalt',
            'name.max' => 'A csapat neve túl hosszú',
            'shortname.required' => 'A csapat rövid nevének megadása kötelező',
            'shortname.unique' => 'A csapat rövid neve már foglalt',
            'shortname.min' => 'A csapat rövid neve 4 karakter hosszú kell legyen',
            'shortname.max' => 'A csapat rövid neve 4 karakter hosszú kell legyen',
            'image.image' => 'A csapat logója csak kép lehet',
            'image.mimes' => 'A csapat logója csak jpg, jpeg, png, gif vagy svg lehet',
            'image.max' => 'A csapat logója túl nagy'
        ]);

        $team->name = $request->name;
        $team->shortname = $request->shortname;
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $fname = $file->hashName();
            Storage::disk('public')->put('images/' . $fname, $file->get());
            $team->image = $fname;
        }
        $team->save();

        Session::flash('success', 'A csapat sikeresen szerkesztve');
        return redirect()->route('teams.show', ['team' => $team]);
    }

    public function addPlayer(Request $request, Team $team)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $team)))
        {
            Session::flash('error', 'Nincs jogosultságod játékos hozzáadásához');
            return redirect()->route('teams.show', ['team' => $team]);
        }

        $request->validate([
            'playername' => 'required|max:255',
            'number' => 'required|integer|min:1|max:99',
            'birthdate' => 'required|date|before:today',
        ],
        [
            'playername.required' => 'A játékos nevének megadása kötelező',
            'playername.max' => 'A játékos neve túl hosszú',
            'number.required' => 'A játékos mezszámának megadása kötelező',
            'number.integer' => 'A játékos mezszáma csak szám lehet',
            'number.min' => 'A játékos mezszáma nem lehet kisebb, mint 1',
            'number.max' => 'A játékos mezszáma nem lehet nagyobb, mint 99',
            'birthdate.required' => 'A játékos születési dátumának megadása kötelező',
            'birthdate.date' => 'A játékos születési dátuma nem megfelelő formátumú',
            'birthdate.before' => 'A játékos születési dátuma nem lehet a mai napnál későbbi'
        ]);

        $player = new Player();
        $player->name = $request->playername;
        $player->number = $request->number;
        $player->birthdate = $request->birthdate;
        $player->team_id = $team->id;
        $player->team()->associate($team);
        $player->save();

        Session::flash('success', 'A játékos sikeresen hozzáadva a csapathoz');
        return redirect()->route('teams.show', ['team' => $team]);
    }

    public function destroyPlayer(Team $team, Player $player)
    {
        if (!(Auth::check() && Auth::user()->can('edit', $team)))
        {
            Session::flash('error', 'Nincs jogosultságod játékos törléséhez');
            return redirect()->route('teams.show', ['team' => $team]);
        }

        if ($player->events->count() > 0)
        {
            Session::flash('error', 'A játékos nem törölhető, mert van hozzárendelve esemény');
            return redirect()->route('teams.show', ['team' => $team]);
        }

        $player->delete();

        Session::flash('success', 'A játékos sikeresen törölve a csapatból');
        return redirect()->route('teams.show', ['team' => $team]);
    }
}
?>