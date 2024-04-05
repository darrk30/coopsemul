<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::role('Profesor')->get()->random()->id;

        return [
            'apellidos' => $this->faker->lastName,
            'biografia' => $this->faker->text(50),
            'especialidad' => $this->faker->word,
            'dni' => $this->faker->numberBetween(10000000, 99999999),
            'status' => $this->faker->numberBetween(0, 1),
            'user_id' =>  $user_id,
        ];
    }
}
