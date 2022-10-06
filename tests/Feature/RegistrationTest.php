<?php

namespace Tests\Feature;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_main_route()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_user_as_coach_register()
    {
        $user = new User();

        $user->firstname = 'Иванов';
        $user->secondname = 'Иван';
        $user->patronymic = 'Иванович';
        $user->date_of_birth = '01.01.2000';
        $user->email = 'test@test.ru';
        $user->phone = '+7 (000) 000-00-00';
        $user->role_id = '4';
        $user->password = Hash::make(123);
        $user->save();

        Auth::login($user);

        $coach = new Coach();
        $coach->user_id = $user->id;
        $coach->code = rand(1000, 9999);
        $coach->save();

        $response = $this->actingAs($user)->get('/coach/'.$coach->id);
        $response->assertOk();
    }
}
