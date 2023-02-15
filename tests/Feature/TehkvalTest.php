<?php

namespace Tests\Feature;

use App\Models\Athlete;
use App\Models\Role;
use App\Models\Tehkval;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TehkvalTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tehkval()
    {
        $user = User::with('organizations')->find(1);
        Auth::login($user);

        $athlete = Athlete::find(1);
        $tehkval = Tehkval::find(1);

        $this->post('/tehkval', [
            'athlete_id' => $athlete->id,
            'tehkval_id' => $tehkval->id,
            'organization_id' => $user->organizations->first()->id,
        ]);

        $athlete->tehkval()->attach($tehkval->id, ['organization_id' => $user->organizations->first()->id]);

        $response = $this->assertDatabaseHas('athlete_tehkval', [
            'athlete_id' => $athlete->id,
            'tehkval_id' => $tehkval->id
        ]);


    }
}
