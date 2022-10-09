<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store_address()
    {
        $this->withoutMiddleware();
        $user = User::where('id', '1')->first();
        Auth::login($user);
        $this->post('/addresses', [
            'country_id' => 1,
            'district_id' => 1,
            'region_id' => 1,
            'address' => 'г. Волгоград, ул. Строителей, д. 17, кв. 1',
            'registration_scan' => UploadedFile::fake()->image('photo.jpg'),
            'user_id' => 1
        ]);

        $response = $this->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(302);
    }
}
