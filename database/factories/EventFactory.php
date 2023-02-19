<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'date_start' => $this->faker->date(),
            'date_end' => $this->faker->date(),
            'address' => $this->faker->address,
            'organization_id' => 1,
            'open' => 1,
            'users_limit' => 100,
            'access' => Event::ACCESS_ALL,
        ];
    }
}
