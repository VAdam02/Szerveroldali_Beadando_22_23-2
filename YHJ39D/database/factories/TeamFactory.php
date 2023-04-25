<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $teamname = fake()->unique()->company;
        $shortname = substr($teamname, 0, 2) . fake()->unique()->numberBetween(0, 99);

        return [
            'name' => $teamname,
            'shortname' => $shortname,
            'image' => fake()->imageUrl($width = 100, $height = 100, $teamname),
        ];
    }
}
