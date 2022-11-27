<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\CompetitionsRanksTitle;
use App\Models\Country;
use App\Models\District;
use App\Models\Organization;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CompetitionsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_competitions_index()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $response = $this->get('/competitions');
        $response->assertStatus(200);
    }

    public function test_competitions_create()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $response = $this->get('/competitions/create');
        $response->assertStatus(200);
    }

    public function test_competitions_store()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();

        $country = Country::first();
        $district = District::first();
        $region = Region::first();
        $status = CompetitionsRanksTitle::first();

        $this->post('/competitions', [
            'title' => 'Тестовые соревнованя',
            'org_id' => $organization->id,
            'status' => $status->id,
            'country_id' => $country->id,
            'district_id' => $district->id,
            'region_id' => $region->id,
            'agecategory' => [1,2,3,4],
            'address' => 'г. Волгоград, ЦСКА',
            'date_start' => '2000-10-10',
            'date_end' => '2000-10-10',
            'linkreport' => 'http://tesst',
            ]);

        $comp = Competition::where('title', 'Тестовые соревнованя')->first();

        $comp->agecategories()->detach();

        $comp->agecategories()->attach([1,2,3,4]);

        $comp->organizations()->attach($organization->id);

        $this->assertDatabaseHas('competitions', [
            'title' => $comp->title
        ]);

        $response = $this->followingRedirects()->get('competitions');
        $response->assertStatus(200);
    }

    public function test_competitions_show()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $competition = Competition::first();

        $response = $this->get('competitions/'.$competition->id);
        $response->assertStatus(200);
    }

    public function test_competitions_edit()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $competition = Competition::first();
        $response = $this->get('/competitions/'.$competition->id.'/edit');
        $response->assertStatus(200);
    }

    public function test_competitions_update()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();
        $competition = Competition::first(); //сделать под собственника соревнований

        $country = Country::first();
        $district = District::first();
        $region = Region::first();
        $status = CompetitionsRanksTitle::first();

        $this->put('/competitions/'.$competition->id, [
            'title' => 'Тестовые соревнованя2',
            'org_id' => $organization->id,
            'status' => $status->id,
            'country_id' => $country->id,
            'district_id' => $district->id,
            'region_id' => $region->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date_start' => '2000-10-10',
            'agecategory' => [1,2,3,4],
            'date_end' => '2000-10-10',
            'linkreport' => 'http://tesst',
        ]);

        $comp = Competition::where('title', 'Тестовые соревнованя2')->first();

        $response = $this->followingRedirects()->get('competitions');
        $response->assertStatus(200);
    }

    public function test_competitions_destroy()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $max = Competition::where('id', '!=', null)->max('id'); //сделать под собственника соревнований
        $competition = Competition::where('id', $max)->first(); //сделать под собственника соревнований

        $competition->agecategories()->detach();
        $competition->organizations()->detach();
        $this->delete('/competitions/'.$competition->id);

        $response = $this->followingRedirects()->get('competitions');
        $response->assertStatus(200);
    }


}
