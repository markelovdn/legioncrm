<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\V1\UsersController;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;
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
        $this->post('/create-user', [
                        'firstname'=>'Иванов',
                        'secondname' => 'Иван',
                        'patronymic' => 'Иванович',
                        'date_of_birth' => '2000-01-01',
                        'email' => 'test@test.ru',
                        'phone' => '+7 (000) 000-00-00',
                        'role_id' => '4',
                        'password' => '123123',
                        'password_confirmation' => '123123',
                        'org_id' => '1',
                        'reg_code' => '2217'
                    ]);


        $user = User::where('email', 'test@test.ru')->first();

        Auth::login($user);

        $coach = new Coach();
        $coach->user_id = $user->id;
        $coach->code = rand(1000, 9999);
        $coach->save();

        $response = $this->actingAs($user)->get('/coach/'.$coach->id);
        $response->assertStatus(200);
    }

    public function test_user_as_coach_errcode()
    {
        $response = $this->post('/create-user', [
            'firstname'=>'Иванов',
            'secondname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_id' => '4',
            'password' => '123123',
            'password_confirmation' => '123123',
            'org_id' => '1',
            'reg_code' => '2218'
        ]);

        $response->assertStatus(302);
    }

    public function test_user_as_parent_register()
    {
        $this->post('/create-user', [
            'firstname'=>'Иванов',
            'secondname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_id' => '5',
            'password' => '123123',
            'password_confirmation' => '123123',
            'coach_id' => '1',
            'reg_code' => '1234'
        ]);


        $user = User::where('email', 'test@test.ru')->first();

        Auth::login($user);

        $parented = new Parented();
        $parented->user_id = $user->id;
        $parented->save();

        $response = $this->actingAs($user)->get('/parented/'.$parented->id);
        $response->assertStatus(200);
    }

    public function test_user_as_parent_errcode()
    {
        $response = $this->post('/create-user', [
            'firstname'=>'Иванов',
            'secondname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_id' => '5',
            'password' => '123123',
            'password_confirmation' => '123123',
            'coach_id' => '1',
            'reg_code' => '1235'
        ]);

        $response->assertStatus(302);
    }
}
