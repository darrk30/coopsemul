<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\ContenidoCurso;
use App\Models\DetalleCurso;
use App\Models\Documento;
use App\Models\Lesion;
use App\Models\Level;
use App\Models\Noticia;
use App\Models\Precio;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{
           
    public function run(): void
    {
        Storage::deleteDirectory('public/images');
        Storage::makeDirectory('public/images');   
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        Category::factory(4)->create();
        Precio::factory(10)->create();
        Level::factory(4)->create();
        Category::factory(4)->create();
        $this->call(CursoSeeder::class);
        ContenidoCurso::factory(50)->create();
        Lesion::factory(100)->create();
        Noticia::factory(5)->create();
        Documento::factory(5)->create();
        $this->call(ProfileSeeder::class);
        
        
        
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
