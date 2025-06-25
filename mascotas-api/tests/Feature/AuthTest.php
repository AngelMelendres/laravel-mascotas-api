<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Juan',
            'email' => 'juan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)->assertJsonStructure(['user', 'token']);
    }

    public function test_login_user()
    {
        $user = User::factory()->create(['password' => bcrypt('12345678')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_get_authenticated_user()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")->getJson('/api/user');
        $response->assertStatus(200)->assertJsonFragment(['email' => $user->email]);
    }
}
