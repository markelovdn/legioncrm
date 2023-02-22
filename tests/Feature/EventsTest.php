<?php

namespace Tests\Feature;

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

class EventsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::find(1);
        Auth::login($user);

        $response = $this->get('/events');
        $response->assertSee(Event::first('title')->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $user = User::find(1);
        Auth::login($user);

        $response = $this->get('/events/create');
        $response->assertSee(User::getUserOrganizations($user->id)->first()->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();

        $this->post('/events', [
            'title' => 'Тестовое мероприятие',
            'org_id' => $organization->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date_start' => '2000-10-10',
            'date_end' => '2000-10-10',
            'info_link' => 'http://tesst',
            'users_limit' => 100,
            'access' => Event::ACCESS_ALL,
            'early_cost' => 14000,
            'early_cost_before' => '2023-03-01',
            'regular_cost' => 15000,
            'minimum_prepayment_percent' => 30,
            'booking_without_payment_before' => 14,
            'payment_control' => Event::PAYMENT_CONTROL_COACH,
        ]);

        $event = Event::where('title', 'Тестовое мероприятие')->first();

        $this->assertDatabaseHas('events', [
            'title' => $event->title
        ]);

        $this->assertDatabaseHas('payments_titles', [
            'title' => 'Платеж за '.$event->title
        ]);

        $response = $this->followingRedirects()->get('/events');
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $event = Event::first();
        $response = $this->get('/events/'.$event->id.'/edit');
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();
        $event = Event::first(); //TODO: сделать под собственника мероприятия

        $this->put('/events/'.$event->id, [
            'title' => 'Тестовое мероприятие2',
            'org_id' => $organization->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date_start' => '2000-10-10',
            'date_end' => '2000-10-10',
            'users_limit' => 100,
            'access' => Event::ACCESS_ALL,
            'info_link' => 'http://tesst',
            'open' => Event::CLOSE_REGISTRATION,
            'deleted_at' => Carbon::now(),
            'early_cost' => 14000,
            'early_cost_before' => '2023-03-01',
            'regular_cost' => 15000,
            'minimum_prepayment_percent' => 30,
            'booking_without_payment_before' => 14,
            'payment_control' => Event::PAYMENT_CONTROL_COACH,
        ]);

        $event = Event::where('title', 'Тестовое мероприятие2')->first();

        $this->assertDatabaseHas('events', [
            'title' => $event->title
        ]);

        $this->assertDatabaseHas('payments_titles', [
            'title' => 'Платеж за '.$event->title
        ]);

        $response = $this->followingRedirects()->get('events');
        $response->assertStatus(200);
    }

    public function test_destroy()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $event = Event::find(1);
        $response = $this->followingRedirects()->delete('/events/'.$event->id);

        $response->assertStatus(200);
    }




}
