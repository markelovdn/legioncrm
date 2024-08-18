<?php

namespace Tests\Feature;

use App\Models\Athlete;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PassportTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store_passport_parented()
    {
        $user = User::with('parented')->has('parented')->first();
        Auth::login($user);
        $this->post('/passport', [
            'passport_series' => 1800,
            'passport_number' => 999999,
            'passport_date_issue' => '2000-01-01',
            'passport_issued_by' => 'Волгоградским РОВД',
            'passport_subcode' => '324-012',
            'role_code' => 'parented',
            'user_id' => 1
        ]);

        $response = $this->followingRedirects()->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(200);
    }

    public function test_store_passport_for_athlete()
    {
        $athlete = Athlete::with('parenteds')->has('parenteds')->first();
        $user = User::with('parented')->has('parented')->first();
        Auth::login($user);
        $this->post('/passport', [
            'passport_series' => 1800,
            'passport_number' => 999999,
            'passport_date_issue' => '2000-01-01',
            'passport_issued_by' => 'Волгоградским РОВД',
            'passport_subcode' => '324-012',
            'athlete_id' => $athlete->id,
            'user_id' => $user->id,
            'role_code' => 'athlete',
            'passport_scan' => UploadedFile::fake()->image('photo.jpg')

        ]);

        $response = $this->followingRedirects()->actingAs($user)->get('/parented/'.$user->id);

        $response->assertStatus(200);
    }
}
