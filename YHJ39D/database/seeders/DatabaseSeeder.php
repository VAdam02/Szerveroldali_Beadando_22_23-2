<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

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
    }
}
