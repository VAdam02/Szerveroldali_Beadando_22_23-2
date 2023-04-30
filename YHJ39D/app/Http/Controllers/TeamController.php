<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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





    public function createTeam(Request $request)
    {
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
}
?>