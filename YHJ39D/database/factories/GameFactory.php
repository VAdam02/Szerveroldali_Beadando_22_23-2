<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'start' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null),
            'finished' => $this->faker->boolean($chanceOfGettingTrue = 50),

            'HomeTeamScore' => $this->faker->numberBetween($min = 0, $max = 10),
            'AwayTeamScore' => $this->faker->numberBetween($min = 0, $max = 10)
        ];
    }
}
