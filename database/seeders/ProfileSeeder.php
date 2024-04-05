<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perfiles = Profile::factory(7)->create();

        foreach($perfiles as $perfil){
            Image::factory(1)->create([
                'imageable_id' => $perfil->id,
                'imageable_type' => Profile::class,
            ]);
        }
    }
}
