<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teams = collect();
        $teamCount = rand(10, 20);
        for ($i = 1; $i <= $teamCount; $i++)
        {
            $team = Team::factory()->create();
            $teams->add($team);
        }

        $players = collect();
        $playerCount = rand(100, 200);
        for ($i = 1; $i <= $playerCount; $i++)
        {
            $player = Player::factory()->create();
            $player->team()->associate($teams->random());
            $players->add($player);
        }

        /*
        $events = collect();
        $eventCount = rand(200, 500);
        for ($i = 1; $i <= $eventCount; $i++)
        {
            $event = Event::factory()->create();
            $events->add($event);
        }

        $games = collect();
        $gameCount = rand(20, 30);
        for ($i = 1; $i <= $gameCount; $i++)
        {
            $game = Game::factory()->create();
            $games->add($game);
        }

        $players = collect();
        $playerCount = rand(100, 200);
        for ($i = 1; $i <= $playerCount; $i++)
        {
            $player = Player::factory()->create();
            $players->add($player);
        }

        $teams = collect();
        $teamCount = rand(10, 20);
        for ($i = 1; $i <= $teamCount; $i++)
        {
            $team = Team::factory()->create();
            $teams->add($team);
        }

        $users = collect();
        $userCount = rand(10, 20);
        for ($i = 1; $i <= $userCount; $i++)
        {
            $user = User::factory()->create([
                'email' => 'user' . $i .  '@szerveroldali.hu'
            ]);
            $users->add($user);
        }
        */
    }
}
