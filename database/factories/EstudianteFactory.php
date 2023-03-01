<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $prioridades = ['alumno regular', 'prioritario', 'nuevo prioritario'];
        return [
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'es_nuevo' =>  rand(0,1) == 1,
            'prioridad'=> $prioridades[rand(0,2)],
            'email_institucional' => fake()->email(),
        ];
    }
}
