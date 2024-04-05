<?php

namespace Database\Factories;

use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    protected $model = Level::class;
  
    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
