<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{

    public function definition(): array
    {
        return [
            
            'url' => 'images/' . $this->faker->image('public/storage/images', 1920, 505, null, false),

        ];
    }
}
