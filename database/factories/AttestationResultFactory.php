<?php

namespace Database\Factories;

use App\Models\Athlete;
use App\Models\Tehkval;
use App\Models\Tqtitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttestationResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sertificatenum' => $this->faker->randomNumber(),
            'athlete_id' => Athlete::where('user_id','!=', null)->first(),
            'tehkval_id' => 2,
        ];
    }
}
