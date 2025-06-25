<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Persona;
use App\Models\Mascota;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MascotaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_mascota()
    {
        $user = User::factory()->create();
        $persona = Persona::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withToken($token)->postJson('/api/mascotas', [
            'nombre' => 'Toby',
            'especie' => 'perro',
            'raza' => 'Labrador',
            'edad' => 3,
            'persona_id' => $persona->id,
        ]);

        $response->assertStatus(201)->assertJsonFragment(['nombre' => 'Toby']);
    }

    public function test_no_permite_mismo_nombre_para_misma_persona()
    {
        $persona = Persona::factory()->create();
        Mascota::factory()->create([
            'persona_id' => $persona->id,
            'nombre' => 'Luna',
        ]);

        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withToken($token)->postJson('/api/mascotas', [
            'nombre' => 'Luna',
            'especie' => 'gato',
            'raza' => 'Siamés',
            'edad' => 2,
            'persona_id' => $persona->id,
        ]);

        $response->assertStatus(422);
    }
}
