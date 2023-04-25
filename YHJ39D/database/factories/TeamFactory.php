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
        return [
            'TeamLogo' => $this->faker->imageUrl($width = 100, $height = 100, 'cats', true, 'Faker'),
            'TeamName' => $this->faker->company,
            'TeamShortName' => $this->faker->companySuffix,
        ];
    }
}
