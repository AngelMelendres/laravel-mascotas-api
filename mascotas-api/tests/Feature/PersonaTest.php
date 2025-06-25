<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Persona;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_persona()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withToken($token)->postJson('/api/personas', [
            'nombre' => 'María',
            'email' => 'maria@example.com',
            'fecha_nacimiento' => '1990-01-01',
        ]);

        $response->assertStatus(201)->assertJsonFragment(['nombre' => 'María']);
    }

    public function test_obtener_persona_con_mascotas()
    {
        $persona = Persona::factory()->create();
        $persona->mascotas()->create([
            'nombre' => 'Copito',
            'especie' => 'perro',
            'raza' => 'Poodle',
            'edad' => 5,
        ]);

        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withToken($token)->getJson("/api/personas/{$persona->id}/mascotas");

        $response->assertStatus(200)->assertJsonFragment(['nombre' => 'Copito']);
    }
}
