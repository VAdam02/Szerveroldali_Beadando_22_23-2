<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Game;

class PlayerIsInGame implements Rule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $player_id)
    {
        $game = Game::find($this->request->game_id);
        $player_ids = $game->homeTeam->players->merge($game->awayTeam->players)->map(function ($player) {
            return $player->id;
        });
        return $player_ids->contains($player_id);
    }

    public function message()
    {
        return 'A játékos nem szerepel a mérkőzésen.';
    }
}
