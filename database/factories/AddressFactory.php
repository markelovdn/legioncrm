<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => 1,
            'district_id' => 1,
            'region_id' => 1,
            'address' => $this->faker->address,
        ];
    }
}
