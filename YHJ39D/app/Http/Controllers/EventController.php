<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            'minute' => 'required|integer|min:1|max:90',
            'player_id' => 'required|exists:players,id',
            'game_id' => 'required|exists:games,id',
            'type' => 'required|in:gól,öngól,sárga lap,piros lap',
        ],
        [
            'minute.required' => 'A perc megadása kötelező!',
            'minute.integer' => 'A perc csak szám lehet!',
            'minute.min' => 'A perc nem lehet kisebb, mint 1!',
            'minute.max' => 'A perc nem lehet nagyobb, mint 90!',
            'player_id.required' => 'A játékos kiválasztása kötelező!',
            'player_id.exists' => 'A kiválasztott játékos nem létezik!',
            'game_id.required' => 'A mérkőzés kiválasztása kötelező!',
            'game_id.exists' => 'A kiválasztott mérkőzés nem létezik!',
            'type.required' => 'A típus kiválasztása kötelező!',
            'type.in' => 'A kiválasztott típus nem létezik!',
        ]);
        $event = new Event();
        $event->minute = $request->minute;
        $event->game_id = $request->game_id;
        $event->player_id = $request->player_id;
        $event->type = $request->type;
        $event->game()->associate($request->game_id);
        $event->player()->associate($request->player_id);
        $event->save();
        return redirect()->route('games.show', ['game' => $request->game_id])->with('success', 'Esemény sikeresen létrehozva!');
    }
}