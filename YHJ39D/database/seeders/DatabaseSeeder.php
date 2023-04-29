<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;

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
        foreach ($teams as $team)
        {
            $playerCount = 11;
            for ($i = 1; $i <= $playerCount; $i++)
            {
                $player = Player::factory()->create([
                    'team_id' => $team->id
                ]);
                $player->team()->associate($team);
                $players->add($player);
            }
        }

        $games = collect();
        $gameCount = rand(25, 50);
        for ($i = 1; $i <= $gameCount; $i++)
        {
            $team1 = $teams->random();
            $team2 = $teams->random();
            $game = Game::factory()->create([
                'home_team_id' => $team1->id,
                'away_team_id' => $team2->id
            ]);
            $games->add($game);
        }

        $events = collect();
        foreach ($games as $game)
        {
            if ($game->started > Carbon::now()) { continue; }
            
            $eventCount = rand(10, 20);
            for ($i = 1; $i <= $eventCount; $i++)
            {
                //select a random player from $game->homeTeam or $game->awayTeam
                if (rand(0,2) == 0)
                {
                    $player = $players->where('team_id', $game->home_team_id)->random();
                }
                else
                {
                    $player = $players->where('team_id', $game->away_team_id)->random();
                }

                $event = Event::factory()->create([
                    'player_id' => $player->id,
                    'game_id' => $game->id
                ]);
                $event->game()->associate($game);
                $event->player()->associate($player);
                $events->add($event);
            }
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

        $users->add(User::factory()->create([
            'email' => 'admin@szerveroldali.hu',
            'is_admin' => true,
            'password' => bcrypt('adminpwd')
        ]));

        foreach ($users as $user)
        {
            $teamCount = rand(0, 10);
            for ($i = 1; $i <= $teamCount; $i++)
            {
                $team = $teams->random();
                $user->teams()->attach($team);
            }
        }
    }
}
