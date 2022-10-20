<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BirthCertificateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store_address()
    {
        $user = User::get()->first();
        Auth::login($user);
        $this->post('/birthcertificate', [
            'birthcertificate_series' => 'I-РК',
            'birthcertificate_number' => 123123,
            'birthcertificate_date_issue' => '2000-01-01',
            'birthcertificate_issued_by' => 'Отдел ЗАГС Советского района Волгоградской области',
            'birthcertificate_scan' => UploadedFile::fake()->image('photo.jpg'),
            'user_id' => 1
        ]);

        $response = $this->followingRedirects()->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(200);
    }
}
