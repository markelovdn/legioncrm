<?php

namespace Database\Factories;

use App\Models\Age;
use App\Models\Athlete;
use App\Models\Competition;
use App\Models\CompetitionsRanksPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionsResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number_of_fights' => $this->faker->randomElement(['1','2','3','4','5','6','7']),
            'place' => $this->faker->randomElement(['1','2','3','4','5','6','7', '8', '9']),
            'athlete_id' => Athlete::factory(),
            'competition_id' => Competition::factory(),
            'weight_id' => 4,
            'age_id' => 4,
            'rankpoint_id' => CompetitionsRanksPoint::factory(),
        ];
    }
}
