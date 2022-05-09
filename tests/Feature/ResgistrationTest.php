<?php

namespace Tests\Feature;

use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResgistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_register()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'authToken',
            'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        $user = User::factory()->make();
        $response = $this->post(route('register'), $user->toArray());
        // $this->assertAuthenticated();
        $response->assertStatus(200);
    }
}
