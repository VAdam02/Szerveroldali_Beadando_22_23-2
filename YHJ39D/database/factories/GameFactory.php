<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (fake()->boolean($chanceOfGettingTrue = 40)) { //already finished
            $start = fake()->dateTimeBetween($startDate = '-1 weeks', $endDate = '-90 minutes', $timezone = null);
        } else if (fake()->boolean($chanceOfGettingTrue = 20)) { //in progress
            $start = fake()->dateTimeBetween($startDate = '-90 minutes', $endDate = '+0 minutes', $timezone = null);
        } else { //not started
            $start = fake()->dateTimeBetween($startDate = '+0 minutes', $endDate = '+1 weeks', $timezone = null);
        }

        //$start = fake()->dateTimeBetween($startDate = '-1 weeks', $endDate = '+1 weeks', $timezone = null);
        return [
            'start' => $start,
            //'finished' => $start < Carbon::now() ? fake()->boolean($chanceOfGettingTrue = 50) : false
            //finished if starttime + 90 minute ellapsed
            'finished' => $start < Carbon::now()->subMinutes(90) ? true : false
        ];
    }
}
