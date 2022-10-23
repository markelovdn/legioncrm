<?php

namespace Database\Factories;

use App\Models\Athlete;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'athlete_id' => Athlete::factory(),
            'weight' => $this->faker->numberBetween($min = 20, $max = 100),
        ];
    }
}
