<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\BirthCertificate;
use App\Models\Coach;
use App\Models\Country;
use App\Models\District;
use App\Models\Group;
use App\Models\MedicalPolicy;
use App\Models\Organization;
use App\Models\Passport;
use App\Models\Region;
use App\Models\Snils;
use App\Models\StudyPlace;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'user_id'=>User::factory(),
            'gender' => $this->faker->randomElement([1, 2]),
            'photo' => $this->faker->imageUrl,
            'status' => $this->faker->randomElement(['1', '0']),
            'studyplace_id'=>StudyPlace::factory(),
            'passport_id'=>Passport::factory(),
            'birthcertificate_id'=>BirthCertificate::factory(),
            'snils_id'=>Snils::factory(),
            'medicalpolicy_id'=>MedicalPolicy::factory(),
        ];
    }
}
