<?php

namespace Tests\Feature;

use App\BusinessProcess\GetEventUsers;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EventsUsersTest extends TestCase
{
    use DatabaseTransactions;
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
            'payment_id' => 1,
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

        $this->followingRedirects()->post('/events/'.$event->id.'/users', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::APPROVE,
            'payment_id' => 1,
            'list' => Event::MAIN_LIST,
        ]);

        $response = $this->followingRedirects()->put('/event/'.$event->id.'/user/7', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::DECLINE,
            'payment_id' => 0,
            'list' => Event::MAIN_LIST,
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

    public function test_destroy()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $event = Event::find(1);
        $this->followingRedirects()->delete('/event/'.$event->id.'/user/7');

        $response = $this->followingRedirects()->put('/event/'.$event->id.'/user/7', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::DECLINE,
            'payment_id' => 0
        ]);

        $this->assertDatabaseMissing('event_user', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::DECLINE,
            'payment_id' => 0
        ]);

        $response->assertStatus(200);
    }

    public function test_store_up_limit()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();
        $event = Event::first();

        $this->put('/events/'.$event->id, [
            'title' => 'Тестовое мероприятие2',
            'org_id' => $organization->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date_start' => '2000-10-10',
            'date_end' => '2000-10-10',
            'users_limit' => 0,
            'access' => Event::ACCESS_ALL,
            'info_link' => 'http://tesst',
            'open' => Event::CLOSE_REGISTRATION,
            'deleted_at' => Carbon::now(),
            'early_cost' => 14000,
            'early_cost_before' => '2023-03-01',
            'regular_cost' => 15000,
            'minimum_prepayment_percent' => 30,
            'booking_without_payment_before' => 14,
        ]);

        $response = $this->followingRedirects()->post('/events/'.$event->id.'/users', [
            'user_id' => 7,
            'event_id' => $event->id,
            'approve' => Event::APPROVE,
            'payment_id' => 1,
            'list'=> Event::WAITING_LIST
        ]);
//        TODO: переделать передачу user_id

        $this->assertDatabaseHas('event_user', [
            'user_id' => 7,
            'event_id' => $event->id,
            'list' => Event::WAITING_LIST,
        ]);

        $response->assertStatus(200);
    }
}
