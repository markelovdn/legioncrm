<?php

namespace Database\Factories;

use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Tehkval;
use App\Models\Sportkval;
use App\Models\Coach;
use App\Models\Club;
use App\Models\AgeCategory;
use App\Models\TehkvalGroup;
use App\Models\WeightCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
