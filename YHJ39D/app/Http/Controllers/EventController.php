<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Game;
use App\Rules\PlayerIsInGame;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            'minute' => 'required|integer|min:1|max:90',
            'game_id' => 'required|integer|exists:games,id',
            'player_id' => ['required', 'integer', new PlayerIsInGame($request)],
            'type' => 'required|in:gól,öngól,sárga lap,piros lap',
        ], [
            'minute.required' => 'A perc megadása kötelező!',
            'minute.integer' => 'A perc csak szám lehet!',
            'minute.min' => 'A perc nem lehet kisebb, mint 1!',
            'minute.max' => 'A perc nem lehet nagyobb, mint 90!',
            'player_id.required' => 'A játékos kiválasztása kötelező!',
            'player_id.exists' => 'A kiválasztott játékos nem létezik vagy nem játszik a mérkőzésen!',
            'game_id.required' => 'A mérkőzés kiválasztása kötelező!',
            'game_id.exists' => 'A kiválasztott mérkőzés nem létezik!',
            'type.required' => 'A típus kiválasztása kötelező!',
            'type.in' => 'A kiválasztott típus nem létezik!',
        ]);

        if (!(Auth::check() && Auth::user()->can('create', Event::class)))
        {
            Session::flash('error', 'Nincs jogosultságod eseményt létrehozni!');
            return redirect()->route('games.show', ['game' => $request->game_id]);
        }

        if (app(GameController::class)->activeGames()->where('id', $request->game_id)->count() == 0) {
            Session::flash('error', 'A kiválasztott mérkőzés már befejeződött!');
            return redirect()->route('games.show', ['game' => $request->game_id]);
        }

        $event = new Event();
        $event->minute = $request->minute;
        $event->game_id = $request->game_id;
        $event->player_id = $request->player_id;
        $event->type = $request->type;
        $event->game()->associate($request->game_id);
        $event->player()->associate($request->player_id);
        $event->save();
        Session::flash('success', 'Esemény sikeresen létrehozva!');
        return redirect()->route('games.show', ['game' => $request->game_id]);
    }

    public function destroy(Event $event)
    {
        if (!(Auth::check() && Auth::user()->can('delete', $event)))
        {
            Session::flash('error', 'Nincs jogosultságod eseményt törölni!');
            return redirect()->route('games.show', ['game' => $event->game_id]);
        }

        $this->authorize('delete', $event);
        if ($event->game->finished) {
            Session::flash('error', 'A mérkőzés véget ért, nem lehet eseményt törölni!');
            return redirect()->route('games.show', ['game' => $event->game_id]);
        }

        $event->delete();
        Session::flash('success', 'Esemény sikeresen törölve!');
        return redirect()->route('games.show', ['game' => $event->game_id]);
    }
}