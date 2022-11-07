<?php

namespace Database\Factories;

use App\Models\AgeCategory;
use App\Models\Athlete;
use App\Models\TehkvalGroup;
use App\Models\WeightCategory;
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
            'athlete_id' => Athlete::where('user_id','!=', null)->first(),
            'weight' => 30,
            'lot' => 1,
            'agecategory_id' => AgeCategory::first(),
            'weightcategory_id' => WeightCategory::first(),
            'tehkvalgroup_id' => TehkvalGroup::first()
        ];
    }
}
