<?php

namespace Database\Factories;

use App\Models\Documento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class documentoFactory extends Factory
{
    protected $model = Documento::class;

    public function definition(): array
    {
        $titulo = $this->faker->sentence(); // Genera un título de manera aleatoria
        $url = $this->faker->url(); // Genera una URL aleatoria
        $status = $this->faker->numberBetween(0, 1); // Genera un número aleatorio entre 0 y 1 para el estado

        return [
            'titulo' => $titulo,
            'url' => $url,
            'status' => $status,
        ];
    }
}
