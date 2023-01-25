<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_payment()
    {
        $user = User::with('parented')->has('parented')->first();
        Auth::login($user);
        $this->post('/payment', [
            'user_id' => $user->id,
            'sum_payment' => '1500',
            'date_payment' => date('Y-m-d'),
            'paymenttitle_id' => Payment::ID_YEAR_PAYMENT,
            'scan_payment_document' => UploadedFile::fake()->image('scan_payment_document.jpg'),
        ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id
        ]);

        $response = $this->followingRedirects()->actingAs($user)->get('/parented/'.$user->id);
        $response->assertStatus(200);
    }
}
