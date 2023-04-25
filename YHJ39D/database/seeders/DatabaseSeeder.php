<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Team;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $games = collect();
        $gameCount = rand(10, 20);
        for ($i = 1; $i <= $gameCount; $i++)
        {
            $game = Game::factory()->create();
            $games->add($game);
        }

        $teams = collect();
        $teamCount = rand(10, 20);
        for ($i = 1; $i <= $teamCount; $i++)
        {
            $team = Team::factory()->create();
            $teams->add($team);
        }
    }
}
