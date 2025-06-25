<?php

namespace Database\Factories;

use App\Models\Mascota;
use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mascota>
 */
class MascotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = Mascota::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'especie' => $this->faker->randomElement(['perro', 'gato']),
            'raza' => $this->faker->word,
            'edad' => $this->faker->numberBetween(1, 15),
            'persona_id' => Persona::factory(),
            'imagen_url' => $this->faker->imageUrl(),
        ];
    }
}
