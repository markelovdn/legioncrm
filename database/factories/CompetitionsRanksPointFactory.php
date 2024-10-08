<?php

namespace Database\Factories;

use App\Models\AgeCategory;
use App\Models\CompetitionsRanksTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionsRanksPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'point'=>$this->faker->randomElement([
                '100','200','300'
            ]),
            'compranktitle_id'=>1,
            'age_id'=>4
        ];
    }
}
