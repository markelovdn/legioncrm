<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo' => $this->faker->imageUrl,
            'code' => $this->faker->numberBetween(1000, 9999),
            'user_id' => User::with('role')->has('role')->where('id','=', '4')->first(),
        ];
    }
}
