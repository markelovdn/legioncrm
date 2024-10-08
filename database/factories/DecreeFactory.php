<?php

namespace Database\Factories;

use App\Models\Athlete;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecreeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'series' => $this->faker->randomNumber(),
            'num' => $this->faker->randomNumber(),
            'dateissue'=> $this->faker->date(),
            'title'=>$this->faker->title(),
            'scanlink'=>$this->faker->imageUrl(),
            'organization_id'=>1,
            'athlete_id'=>Athlete::factory(),
        ];
    }
}
