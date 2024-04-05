<?php

namespace Database\Factories;

use App\Models\ContenidoCurso;
use App\Models\Lesion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesion>
 */
class LesionFactory extends Factory
{
    protected $model = Lesion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence,
            // 'url' => $this->faker->url,
            // 'iframe' => $this->faker->randomElement(['<iframe src="example.com"></iframe>', '<iframe src="anotherexample.com"></iframe>']),
            'contenido_curso_id' => ContenidoCurso::all()->random()->id,
        ];
    }
}
