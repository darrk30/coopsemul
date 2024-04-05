<?php

namespace Database\Factories;

use App\Models\Precio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Precio>
 */
class PrecioFactory extends Factory
{
    protected $model = Precio::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'value' => $this->faker->randomNumber(),
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
