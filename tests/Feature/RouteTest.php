<?php

namespace Tests\Feature;

use App\Models\Coach;
use App\Models\Parented;
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
        $parented = Parented::where('user_id', '!=', null)->first();
        $user = User::where('id', $parented->user_id)->with('parented')->first();
        Auth::login($user);

        $response = $this->get('/parented/'.$user->parented->id);

        $response->assertStatus(200);
    }

    public function test_coach_cabinet()
    {
        $coach = Coach::where('user_id', '!=', null)->first();
        $user = User::where('id', $coach->user_id)->with('coach')->first();
        Auth::login($user);

        $response = $this->get('/coach/'.$user->coach->id);

        $response->assertStatus(200);
    }
}
