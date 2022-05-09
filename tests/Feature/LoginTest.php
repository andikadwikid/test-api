<?php

namespace Tests\Feature;

use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function any_can_login()
    {
        User::create([
            'name' => 'Test',
            'email' => $email = time() . '@example.com',
            'password' => $password = bcrypt('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
    }
}
