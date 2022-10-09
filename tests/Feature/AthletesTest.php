<?php

namespace Tests\Feature;

use App\Models\Coach;
use App\Models\Parented;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AthletesTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_athlete()
    {
        $coach = Coach::find(1);
        $user = User::where('id', '1')->first();
        Auth::login($user);
        $this->withoutMiddleware();
        $this->post('/athlete', [
            'photo'=> UploadedFile::fake()->image('photo.jpg'),
            'gender' => '1',
            'secondname' => 'Иванов',
            'firstname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'coach_id' => $coach->id,
            'reg_code' => $coach->code,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(302);
    }
}
