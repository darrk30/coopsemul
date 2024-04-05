<?php

namespace Database\Factories;

use App\Models\ContenidoCurso;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContenidoCursoFactory extends Factory
{
    protected $model = ContenidoCurso::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'descripcion' => $this->faker->text(100),
            'curso_id' => Curso::all()->random()->id
        ];
    }
}
