<?php

namespace Database\Factories;

use App\Models\Noticia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class noticiaFactory extends Factory
{
    protected $model = Noticia::class;

    public function definition(): array
    {
        $titulo = $this->faker->sentence(); // Genera un título de manera aleatoria
        $descripcion = $this->faker->paragraph(); // Genera una descripción de texto aleatorio
        $fecha = $this->faker->date(); // Genera una fecha aleatoria
        $status = $this->faker->numberBetween(0, 1); // Genera un número aleatorio entre 0 y 1 para el estado

        return [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'status' => $status,
        ];
    }
}
