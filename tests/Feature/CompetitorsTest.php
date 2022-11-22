<?php

namespace Tests\Feature;

use App\Models\AgeCategory;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Role;
use App\Models\Sportkval;
use App\Models\Tehkval;
use App\Models\TehkvalGroup;
use App\Models\User;
use App\Models\WeightCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
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

    public function test_competitors_store_as()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

        $competitor = Athlete::with('user', 'tehkval', 'sportkval')->find(1);
        $competition = Competition::first();

//        $competitor_date = Carbon::parse($competitor->user->date_of_birth)->year;
//        $now = Carbon::now()->year;
//        $competitor_age = $now - $competitor_date;
//
//        $age_category = AgeCategory::
//        whereRaw($competitor_age.' between `age_start` and `age_finish`')
//            ->first();
//
//        $competition->agecategories()->attach($age_category->id);

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

    public function test_competitors_store_as_new_user()
    {
        $coach = Coach::with('user')->has('user')->first();
        $competition = Competition::first();

//        $competitor_date = Carbon::parse('2000-01-01')->year;
//        $now = Carbon::now()->year;
//        $competitor_age = $now - $competitor_date;
//
//        $age_category = AgeCategory::
//        whereRaw($competitor_age.' between `age_start` and `age_finish`')
//            ->first();
//
//        $competition->agecategories()->attach($age_category->id);

        $sportKval = Sportkval::find(1);
        $tehKval = Tehkval::find(1);

        $response = $this->followingRedirects()->post('/competitions/'.$competition->id.'/competitors-new-user', [
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

        $this->assertDatabaseHas('competitors', [
            'athlete_id' => $athlete->id
        ]);

        $response->assertStatus(200);
    }

    public function test_competitors_store_as_new_user_error_agecategories()
    {
        $coach = Coach::with('user')->has('user')->first();

        $competition = Competition::with('agecategories')->find(1);

        $sportKval = Sportkval::find(1);
        $tehKval = Tehkval::find(1);

        $response = $this->post('/competitions/'.$competition->id.'/competitors-new-user', [
            'gender' => 1,
            'secondname' => 'Иванов',
            'firstname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '1000-01-01',
            'weight' => random_int(54, 80),
            'tehkval_id' => $tehKval->id,
            'sportkval_id' => $sportKval->id,
            'coach_id' => $coach->id,
            'coach_code' => $coach->code,
            'competition_id' => $competition->id,
        ]);

        $response->assertSessionHas('error_age');
    }

    public function test_competitors_store_as_new_user_error_tehkval()
    {
        $coach = Coach::with('user')->has('user')->first();
        $competition = Competition::first();

//        $competitor_date = Carbon::parse('2000-01-01')->year;
//        $now = Carbon::now()->year;
//        $competitor_age = $now - $competitor_date;
//
//        $age_category = AgeCategory::
//        whereRaw($competitor_age.' between `age_start` and `age_finish`')
//            ->first();
//
//        $competition->agecategories()->attach($age_category->id);

        $sportKval = Sportkval::find(1);

        $response = $this->post('/competitions/'.$competition->id.'/competitors-new-user', [
            'gender' => 1,
            'secondname' => 'Иванов',
            'firstname' => 'Иван',
            'patronymic' => 'Иванович',
            'date_of_birth' => '2000-01-01',
            'weight' => random_int(54, 80),
            'tehkval_id' => 20,
            'sportkval_id' => $sportKval->id,
            'coach_id' => $coach->id,
            'coach_code' => $coach->code,
            'competition_id' => $competition->id,
        ]);

        $response->assertSessionHas('error_tehkval');
    }

    public function test_check_unique_competitor_weight_category()
    {
//        $competitor_date = Carbon::parse('2000-01-01')->year;
//        $now = Carbon::now()->year;
//        $competitor_age = $now - $competitor_date;
//        $age_category = AgeCategory::whereRaw($competitor_age.' between `age_start` and `age_finish`')
//            ->first();
//
//        $competition->agecategories()->attach($age_category->id);

        $competition = Competition::first();
        $tehKval = Tehkval::find(1);
        $user = User::find(6);
        $athlete = Athlete::where('user_id', $user->id)->first();

        $weight = 54;
        $weightcategory = WeightCategory::whereRaw($weight.' between `weight_start` and `weight_finish` and `gender` = 1 and `agecategory_id` = 1')
            ->first();

        $tehKvalGroup = TehkvalGroup::
        whereRaw('agecategory_id = 1 and finishgyp_id >= '.$tehKval->id)
            ->first();

        $competitor = new Competitor();
        $competitor->athlete_id = $athlete->id;
        $competitor->weight = $weight;
        $competitor->agecategory_id = 1;
        $competitor->weightcategory_id = $weightcategory->id;
        $competitor->tehkvalgroup_id = $tehKvalGroup->id;
        $competitor->save();

        $competitor->competitions()->attach($competition->id);

        $unique_competitor = Competitor::checkUniqueCompetitorWeightCategory(
            $competitor->athlete_id, $competitor->agecategory_id, $competitor->weightcategory_id,
            $competitor->tehkvalgroup_id, $competition->id);

        $this->assertFalse($unique_competitor);
    }

    public function test_competitor_edit() {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

        $competitor = Competitor::factory(1)->create();
        $competitor_id = $competitor->first()->id;

        $response = $this->get('/competitors/'.$competitor_id.'/edit');
        $response->assertStatus(200);
    }

    public function test_competitor_update() {
        $user = User::whereRelation('role', 'code', Role::ROLE_COACH)->first();
        Auth::login($user);

//        $competitor_date = Carbon::parse('2000-01-01')->year;
//        $now = Carbon::now()->year;
//        $competitor_age = $now - $competitor_date;
//
//        $age_category = AgeCategory::whereRaw($competitor_age.' between `age_start` and `age_finish`')
//            ->first();
//
//        $competition->agecategories()->attach($age_category->id);

        $competition = Competition::first();
        $competitor = Competitor::factory(1)->create();
        $competitor_id = $competitor->first()->id;
        $sportKval = Sportkval::find(1);
        $tehKval = Tehkval::find(1);

        $response = $this->followingRedirects()->put('/competitors/'.$competitor_id, [
            'gender' => 1,
            'weight' => 54,
            'date_of_birth' =>'2000-01-01',
            'tehkval_id' => $tehKval->id,
            'sportval_id' => $sportKval->id,

        ]);
        $response->assertStatus(200);
    }

}
