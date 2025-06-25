<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'fecha_nacimiento' => $this->faker->date(),
        ];
    }
}
