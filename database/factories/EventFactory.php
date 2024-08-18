<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Payment;
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
            'early_cost' => 1000,
            'early_cost_before' => $this->faker->date(),
            'regular_cost' => 2000,
            'minimum_prepayment_percent' => 30,
            'booking_without_payment_before' => 7,
            'payment_control' => Event::PAYMENT_CONTROL_ORGANIZATION,
            'last_date_payment' => $this->faker->date(),

        ];
    }
}
