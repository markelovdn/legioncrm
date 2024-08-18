<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_org_registration_route()
    {
        $response = $this->get('/user/create?organization_chairman');

        $response->assertStatus(200);
    }

    public function test_org_update()
    {
        $user = User::with('role')->has('role')->where('id', '=', '3')->first();

        Auth::login($user);
        $org = Organization::first();

       $this->put('/organization/'.$org->id, [
           'fulltitle' => 'Полное назнвание организации',
           'shorttitle' => 'Не полное',
           'address' => 'Адрес организации',
           'code' => 1111,
       ]);

        $response = $this->followingRedirects()->actingAs($user)->get('organization/'.$org->id);

        $response->assertStatus(200);
    }
}
