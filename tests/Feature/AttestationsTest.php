<?php

namespace Tests\Feature;

use App\Models\Attestation;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AttestationsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::find(1);
        Auth::login($user);

        $response = $this->get('/attestations');
        $response->assertSee(Attestation::first('title')->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $user = User::find(1);
        Auth::login($user);

        $response = $this->get('/attestations/create');
        $response->assertSee(User::getUserOrganizations($user->id)->first()->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();

        $this->post('/attestations', [
            'title' => 'Тестовая аттестация',
            'org_id' => $organization->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date' => '2000-10-10'
        ]);

        $attestation = Attestation::where('title', 'Тестовая аттестация')->first();

        $this->assertDatabaseHas('attestations', [
            'title' => $attestation->title
        ]);

        $response = $this->followingRedirects()->get('/attestations');
        $response->assertSee(User::getUserOrganizations($user->id)->first()->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $attestion = Attestation::first();
        $response = $this->get('/attestations/'.$attestion->id.'/edit');
        $response->assertSee($attestion->title, $escaped = true);
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $organization = Organization::with('users')->whereHas('users')->first();
        $attestation = Attestation::first(); //TODO: сделать под собственника мероприятия

        $this->put('/attestations/'.$attestation->id, [
            'title' => 'Тестовая аттестация2',
            'org_id' => $organization->id,
            'address' => 'г. Волгоград, ЦСКА',
            'date' => '2000-10-10',
            'open' => Attestation::STATUS_CLOSE,
            'archive' => Attestation::ARCHIVE,
        ]);

        $attestation = Attestation::where('title', 'Тестовая аттестация2')->first();

        $this->assertDatabaseHas('attestations', [
            'title' => $attestation->title
        ]);

        $response = $this->followingRedirects()->get('attestations');
        $response->assertStatus(200);
    }

    public function test_destroy()
    {
        $user = User::whereRelation('role', 'code', Role::ROLE_ORGANIZATION_CHAIRMAN)->first();
        Auth::login($user);

        $attestation = Attestation::first();
        $response = $this->followingRedirects()->delete('/attestations/'.$attestation->id);

        $response->assertStatus(200);
    }
}
