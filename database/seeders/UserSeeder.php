<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kevin Daniel',
            'email' => 'kevin@gmail.com',
            'password' => bcrypt('123456789'),            
        ])->assignRole('Administrador');
        
        User::create([
            'name' => 'Axel',
            'email' => 'axel@gmail.com',
            'password' => bcrypt('123456789'),            
        ])->assignRole('Profesor');

        User::create([
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'password' => bcrypt('123456789'),           
        ])->assignRole('Profesor');

        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@gmail.com',
            'password' => bcrypt('123456789'),            
        ])->assignRole('Profesor');

        User::create([
            'name' => 'ram',
            'email' => 'ram@gmail.com',
            'password' => bcrypt('123456789'),            
        ])->assignRole('Profesor');

        User::create([
            'name' => 'rosa',
            'email' => 'rosa@gmail.com',
            'password' => bcrypt('123456789'),           
        ])->assignRole('Profesor');

        User::create([
            'name' => 'angel',
            'email' => 'angel@gmail.com',
            'password' => bcrypt('123456789'),           
        ])->assignRole('Profesor');

        User::create([
            'name' => 'Prueba',
            'email' => 'prueba@gmail.com',
            'password' => bcrypt('123456789'),           
        ])->assignRole('Estudiante');

    }
}
