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
            'start' => fake()->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null),
            'finished' => fake()->boolean($chanceOfGettingTrue = 50),
        ];
    }
}
