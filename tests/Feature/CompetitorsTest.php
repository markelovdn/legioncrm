<?php

namespace Tests\Feature;

use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CompetitorsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_competitiors_index()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $competitions = Competition::first();

        $response = $this->get('/competitions/'.$competitions->id.'/competitors');
        $response->assertStatus(200);
    }

    public function test_competitors_create_as_coach()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

        $competitions = Competition::first();

        $response = $this->get('/competitions/'.$competitions->id.'/competitors/create');
        $response->assertStatus(200);
    }

    public function test_competitiors_store_as()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

        $competitor = Athlete::with('user', 'tehkval', 'sportkval')->where('id', 1)->first();

        $competition = Competition::first();

        $response = $this->followingRedirects()->post('/competitions/'.$competition->id.'/competitors', [
            'weight' => 55,
            'athlete_id' => $competitor->id,
            'competition_id' => $competition->id
        ]);

        $this->assertDatabaseHas('competitors', [
            'athlete_id' => $competitor->id,
            'weight' => 55,
        ]);

        $response->assertStatus(200);
    }

}
