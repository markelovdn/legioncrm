<?php

namespace Tests\Feature;

use App\Models\Coach;
use App\Models\Organization;
use App\Models\Parented;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
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
        $org = Organization::first();
        $this->post('/user', [
            'secondname' => 'Иван',
            'firstname' => 'Иванов',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_code' => 'coach',
            'password' => '123123',
            'password_confirmation' => '123123',
            'org_id' => $org->id,
            'reg_code' => $org->code
        ]);

        $role = Role::where('code', 'coach')->get();

        $user = User::where('email', 'test@test.ru')->first();

        $user->role()->attach($role);

        Auth::login($user);

        $coach = new Coach();
        $coach->user_id = $user->id;
        $coach->code = rand(1000, 9999);
        $coach->save();

        $response = $this->followingRedirects()->actingAs($user)->get('coach/'.$coach->id);

        $response->assertStatus(200);
    }

    public function test_user_as_coach_errcode()
    {
        $response = $this->post('/user', [
            'firstname'=>'Иванов',
            'secondname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_code' => 'coach',
            'password' => '123123',
            'password_confirmation' => '123123',
            'org_id' => '1',
            'reg_code' => '2218'
        ]);

        $response->assertStatus(302);
    }

    public function test_user_as_parent_register()
    {
        $coach = Coach::with('user')->has('user')->first();
        $this->post('/user', [
            'secondname' => 'Иван',
            'firstname' => 'Иванов',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_code' => 'parented',
            'password' => '123123',
            'password_confirmation' => '123123',
            'coach_id' => $coach->id,
            'reg_code' => $coach->code,
        ]);

        $role = Role::where('code', 'parented')->get();

        $user = User::where('email', 'test@test.ru')->first();

        $user->role()->attach($role);

        Auth::login($user);

        $parented = new Parented();
        $parented->user_id = $user->id;
        $parented->save();

        $response = $this->followingRedirects()->actingAs($user)->get('parented/'.$parented->id);

        $response->assertStatus(200);
    }

    public function test_user_as_parent_errcode()
    {
        $response = $this->post('/user', [
            'firstname'=>'Иванов',
            'secondname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'role_code' => 'parented',
            'password' => '123123',
            'password_confirmation' => '123123',
            'coach_id' => '1',
            'reg_code' => '1235'
        ]);

        $response->assertStatus(302);
    }

    public function test_user_as_org_chairman_register()
    {
        $system_code = DB::table('system_codes')->first();
        $this->post('/user', [
            'secondname' => 'Иван',
            'firstname' => 'Иванов',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'email' => 'test@test.ru',
            'phone' => '+7 (000) 000-00-00',
            'reg_code' => $system_code->code,
            'role_code' => 'organization_chairman',
            'password' => '123123',
            'password_confirmation' => '123123',
        ]);

        $role = Role::where('code', 'organization_chairman')->get();

        $user = User::where('email', 'test@test.ru')->first();

        $user->role()->attach($role);

        $org_id = Organization::getChairman()->organizations->first()->id;

        Auth::login($user);

        $response = $this->followingRedirects()->actingAs($user)->get('organization/'.$org_id);

        $response->assertStatus(200);
    }

    public function test_user_unique() {
        $user = User::find(1);
        $coach = Coach::find(1);

        $response = $this->post('/user', [
            'secondname' => $user->secondname,
            'firstname' => $user->firstname,
            'patronymic' => $user->patronymic,
            'date_of_birth' => $user->date_of_birth,
            'email' => 'test@test.ru',
            'phone' => '+7 (123) 000 0000',
            'role_code' => 'athlete',
            'reg_code' => $coach->code,
            'password' => '123123',
            'password_confirmation' => '123123'
        ]);

        $response->assertSessionHas('error_unique_user');
        $response->assertStatus(302);

    }

}
