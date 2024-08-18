<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'date_start'=>$this->faker->date,
          'date_end'=>$this->faker->date,
          'title'=> $this->faker->title,
          'address'=> $this->faker->address,
          'linkreport'=>$this->faker->imageUrl,
          'status'=>$this->faker->randomElement(['1','2']),
          'country_id'=>1,
          'district_id'=>1,
          'region_id'=>1,
        ];
    }
}
