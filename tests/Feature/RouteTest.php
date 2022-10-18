<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_parent_registration()
    {
        $response = $this->get('/user/create?parent');

        $response->assertStatus(200);
    }

    public function test_coach_registration()
    {
        $response = $this->get('/user/create?coach');

        $response->assertStatus(200);
    }

    public function test_parented_cabinet()
    {
        $user = User::where('role_id', '5')->first();
        Auth::login($user);

        $response = $this->get('/parented/1');

        $response->assertStatus(200);
    }

    public function test_coach_cabinet()
    {
        $user = User::where('role_id', '4')->with('coach')->first();
        Auth::login($user);

        $response = $this->get('/coach/'.$user->coach->id);

        $response->assertStatus(200);
    }
}
