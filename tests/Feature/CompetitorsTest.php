<?php

namespace Tests\Feature;

use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CompetitorsTest extends TestCase
{
    use DatabaseTransactions;

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

    public function test_competitiors_store_as_new_user()
    {
        $coach = Coach::with('user')->has('user')->first();
        $competition = Competition::find(1);
        $sportKval = Sportkval::find(1);
        $tehKval = Tehkval::find(1);

        $this->post('/competitions/'.$competition->id.'/competitors-new-user', [
            'gender' => 1,
            'secondname' => 'Иванов',
            'firstname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'weight' => random_int(54, 80),
            'tehkval_id' => $tehKval->id,
            'sportkval_id' => $sportKval->id,
            'coach_id' => $coach->id,
            'coach_code' => $coach->code,
            'competition_id' => $competition->id,
        ]);

        $user = User::where('firstname', 'Иван')
            ->where('secondname', 'Иванов')
            ->where('patronymic', 'Иванович')
            ->where('date_of_birth', '2000-01-01')
            ->first();

        $athlete = Athlete::where('user_id', $user->id)->first();
    }

}
