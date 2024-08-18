<?php

namespace Database\Factories;

use App\Models\Athlete;
use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'validuntil'=> $this->faker->date(),
            'scanlink'=>$this->faker->imageUrl,
            'athlete_id'=>Athlete::where('user_id','!=', null)->first(),
            'organization_id'=>1,
        ];
    }
}
