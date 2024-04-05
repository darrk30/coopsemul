<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word(20);

        return [
            'nombre' => $name,
            'status' => $this->faker->numberBetween(0, 1),           
        ];
    }
}
