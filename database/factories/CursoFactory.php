<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Curso;
use App\Models\Level;
use App\Models\Precio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        static $codigoCounter = 1;
        $codigo = 'CURS-' . str_pad($codigoCounter++, 3, '0', STR_PAD_LEFT);
        $nombre = $this->faker->sentence;
        $descripcion = $this->faker->text(100);       
        $duracion = $this->faker->randomNumber(2);        
        $status = $this->faker->numberBetween(0, 1);        
        $certificado = $this->faker->numberBetween(0, 1);        
        $slug = Str::slug($nombre);
        $category_id = Category::all()->random()->id; // Obtiene un ID aleatorio de la tabla de categorías
        $user_id = User::role('Profesor')->get()->random()->id;
        $precio_id = Precio::all()->random()->id;
        $level_id = Level::all()->random()->id;
        return [
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,            
            'duracion' => $duracion,            
            'status' => $status,            
            'certificado' => $certificado,           
            'slug' => $slug,
            'category_id' => $category_id,
            'user_id' => $user_id,
            'precio_id' => $precio_id,
            'level_id' => $level_id,
        ];
    }
}
