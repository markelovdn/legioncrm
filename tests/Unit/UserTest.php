<?php

namespace Tests\Unit;

use App\Models\Parented;
use App\Models\User;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_main_route()
    {
        $response = $this->get('/');
        $this->assertEquals(302, $response->status());
    }

    public function testCoachCreate()
    {
        $response = $this->post('/');

        $this->assertEquals(200, $response->status());
    }


}
