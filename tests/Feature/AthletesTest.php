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

// class AthletesTest extends TestCase
// {
//     use DatabaseTransactions;
/**
 * A basic feature test example.
 *
 * @return void
 */

    // public function test_index()
    // {
    //     $user = User::find(4);
    //     Auth::login($user);

    //     $response = $this->followingRedirects()->get('/athlete');
    //     $response->assertStatus(200);
    // }

    // public function test_store_athlete()
    // {
    //     $coach = Coach::get()->first();
    //     $user = User::with('parented')->has('parented')->first();

    //     $this->actingAs($user);

    //     $this->post('/athlete', [
    //         'photo'=> UploadedFile::fake()->image('photo.jpg'),
    //         'gender' => '1',
    //         'secondname' => 'Иванов',
    //         'firstname' => 'Иван',
    //         'patronymic' => 'Иванович',
    //         'date_of_birth' => '2000-01-01',
    //         'coach_id' => $coach->id,
    //         'reg_code' => $coach->code,
    //         'user_id' => $user->id
    //     ]);

    //     $this->assertDatabaseHas('users', [
    //         'secondname' => 'Иванов',
    //         'firstname' => 'Иван',
    //         'patronymic' => 'Иванович',
    //     ]);

    //     $response = $this->followingRedirects()->actingAs($user)->get('/parented/'.$user->id);
    //     $response->assertStatus(200);
    // }
// }
