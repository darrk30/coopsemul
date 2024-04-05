<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Profesor']);
        $role3 = Role::create(['name' => 'Estudiante']);
        $role4 = Role::create(['name' => 'Secretaría']);


        Permission::create(['name' => 'admin.home', 'description' => 'Ver el dashboard'])->syncRoles([$role1, $role2, $role3, $role4]);

        //permisos para administar los roles
        Permission::create(['name' => 'admin.roles.index','description' => 'Lista de Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.create','description' => 'Crear Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.edit','description' => 'Editar Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.destroy','description' => 'Eliminar Rol'])->syncRoles([$role1]);

        
        //permisos para el aula virtual
        Permission::create(['name' => 'admin.cursos.index', 'description' => 'Listado de Cursos de Aula Virtual'])->syncRoles([$role2, $role3]);
        Permission::create(['name' => 'admin.cursos.store', 'description' => 'Crear Semana(Profesor)'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.cursos.crear_recurso', 'description' => 'Crear Recurso(Profesor)'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.cursos.eliminar_S_R', 'description' => 'Eliminar Semana o Recurso(Profesor)'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.cursos.formulario', 'description' => 'Ver Formulario para Crear Recurso(Profesor)'])->syncRoles([$role2]);
        Permission::create(['name' => 'admin.cursos.show', 'description' => 'Ingresear al curso(Profesor y Alumno)'])->syncRoles([$role2, $role3]);
        Permission::create(['name' => 'admin.cursos.descargar_recurso', 'description' => 'Descargar Recurso(Profesor y Alumno)'])->syncRoles([$role2, $role3]);

        //Permisos para administrar un curso
        Permission::create(['name' => 'admin.curso.index', 'description' => 'Ver Lista de Cursos(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.curso.create', 'description' => 'Crear Curso(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.curso.edit', 'description' => 'Editar Curso(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.curso.contenido', 'description' => 'Ver Contenido del Curso(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.curso.students', 'description' => 'Ver lista de Matriculados de un Curso(Administrativo)'])->syncRoles([$role1]);


        //Permisos para inscribir alumnos
        Permission::create(['name' => 'admin.matricular.crear', 'description' => 'Matricular Alumnos'])->syncRoles([$role1]);


        //permisos para registrar editar libros
        Permission::create(['name' => 'admin.libros.index', 'description' => 'Lista de libros de la biblioteca(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.libros.create', 'description' => 'Crear Libro(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.libros.edit', 'description' => 'Editar Libro(Administrativo)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.libros.descargar-libro', 'description' => 'Descargar Libro(General)'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.libros.abrir-archivo', 'description' => 'Abrir Libro(General)'])->syncRoles([$role1, $role2, $role3]);
        //roles para la biblioteca del usuario
        Permission::create(['name' => 'admin.miBiblioteca.index', 'description' => 'Ver Lista de Libros(Aula Virtual)'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'admin.miBiblioteca.show', 'description' => 'Ver libros de una categoria(Aula Virtual)'])->syncRoles([$role1, $role2, $role3]);


        //roles para crear usuarios
        Permission::create(['name' => 'admin.colaboradores.index', 'description' => 'Ver lista de Trabajadores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.colaboradores.create', 'description' => 'Crear Trabajadores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.colaboradores.edit', 'description' => 'Editar Trabajadores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.colaboradores.show', 'description' => 'Ver Perfil del Trabajadores'])->syncRoles([$role1]);
    }
}
