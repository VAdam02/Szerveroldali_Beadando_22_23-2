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
            /*
            $table->dateTime('start', $precision = 0);
            $table->boolean('finished')->default(false);
            
            $table->string('homeTeamLogo')->nullable();
            $table->string('homeTeamName');
            $table->string('homeTeamShortName');
            $table->integer('homeTeamScore')->nullable();

            $table->string('awayTeamLogo')->nullable();
            $table->string('awayTeamName');
            $table->string('awayTeamShortName');
            $table->integer('awayTeamScore')->nullable();
            */

            'start' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null),
            'finished' => $this->faker->boolean($chanceOfGettingTrue = 50),

            'homeTeamLogo' => $this->faker->imageUrl($width = 100, $height = 100, 'cats', true, 'Faker'),
            'homeTeamName' => $this->faker->company,
            'homeTeamShortName' => $this->faker->companySuffix,
            'homeTeamScore' => $this->faker->numberBetween($min = 0, $max = 10),

            'awayTeamLogo' => $this->faker->imageUrl($width = 100, $height = 100, 'cats', true, 'Faker'),
            'awayTeamName' => $this->faker->company,
            'awayTeamShortName' => $this->faker->companySuffix,
            'awayTeamScore' => $this->faker->numberBetween($min = 0, $max = 10)
        ];
    }
}
