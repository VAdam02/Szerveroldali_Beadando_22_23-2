<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class, 'home_team_id')->orWhere('away_team_id', $this->id);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
