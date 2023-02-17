<?php

namespace Tests\Feature;

use App\BusinessProcess\GetEventUsers;
use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EventsUsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);
        $event = Event::first();

        $response = $this->get('/events/'.$event->id.'/users');
        $response->assertSee(Event::first('title')->title, $escaped = true);
        $response->assertSee($user->secondname, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_create_users_as_coach()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);
        $event = Event::first();

        $response = $this->get('/events/'.$event->id.'/users/create');
        $response->assertSee(Event::first('title')->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);
        $event = Event::first();

        $response = $this->followingRedirects()->post('/events/'.$event->id.'/users', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::APPROVE,
            'payment_id' => 1
        ]);
//        TODO: переделать передачу user_id

        $this->assertDatabaseHas('event_user', [
            'user_id' => 7,
            'event_id' => $event->id,
        ]);
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);
        $event = Event::first();

        $response = $this->followingRedirects()->put('/event/'.$event->id.'/user/7', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::DECLINE,
            'payment_id' => 0
        ]);
//        TODO: переделать передачу user_id

        $this->assertDatabaseHas('event_user', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::DECLINE,
            'payment_id' => 0
        ]);
        $response->assertStatus(200);
    }

//    public function test_destroy()
//    {
//        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
//        Auth::login($user);
//
//        $event = Event::find(1);
//        $response = $this->followingRedirects()->delete('/competitions/'.$event->id);
//        $response->assertStatus(200);
//    }
}
