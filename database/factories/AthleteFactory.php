<?php

namespace Database\Factories;

use App\Models\BirthCertificate;
use App\Models\MedicalPolicy;
use App\Models\Passport;
use App\Models\Snils;
use App\Models\StudyPlace;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::with('role')->has('role')->where('id','>=', '6')->first(),
            'gender' => $this->faker->randomElement([1, 2]),
            'photo' => 'images/no_photo.jpg',
            'status' => $this->faker->randomElement(['1', '0']),
            'studyplace_id'=> StudyPlace::factory(),
            'passport_id' => Passport::factory(),
            'birthcertificate_id' => BirthCertificate::factory(),
            'snils_id' => Snils::factory(),
            'medicalpolicy_id' => MedicalPolicy::factory(),
        ];
    }
}
