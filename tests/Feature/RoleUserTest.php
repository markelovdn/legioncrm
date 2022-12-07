<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_role_user_route()
    {
        $user = User::find(1);
        Auth::login($user);
        $response = $this->get('/role-user/create');

        $response->assertStatus(200);
    }

    public function test_role_user_route_unAuthorize()
    {
        $response = $this->get('/role-user/create');

        $response->assertStatus(302);
    }

    public function test_role_user_store()
    {
        $user = User::find(1);
        Auth::login($user);

        $role = Role::where('code', 'coach')->first();

        $this->post('/role-user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $user->role()->attach($role);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        $response = $this->followingRedirects()->actingAs($user)->get('role-user');

        $response->assertStatus(200);
    }
}
