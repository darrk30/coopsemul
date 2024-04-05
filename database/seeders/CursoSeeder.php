<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{

    public function run(): void
    {
        $cursos = Curso::factory(10)->create();

        foreach($cursos as $curso){
            Image::factory(1)->create([
                'imageable_id' => $curso->id,
                'imageable_type' => Curso::class,
            ]);
        }
    }
}
