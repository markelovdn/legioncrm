<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class StudyPlaceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store_address()
    {
        $this->withoutMiddleware();
        $user = User::get()->first();
        Auth::login($user);
        $this->post('/studyplace', [
            'org_title' => 'МОУ СШ№54',
            'classnum' => '1',
            'user_id' => 1
        ]);

        $response = $this->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(302);
    }
}
