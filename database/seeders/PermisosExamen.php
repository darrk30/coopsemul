<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisosExamen extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::firstOrCreate(['name' => 'Administrador']);
        $role2 = Role::firstOrCreate(['name' => 'Profesor']);
        $role3 = Role::firstOrCreate(['name' => 'Estudiante']);
        $role4 = Role::firstOrCreate(['name' => 'Secretaría']);

        // Array de permisos específicos que deseas agregar
        $permissions = [
            ['name' => 'admin.examenes.index', 'description' => 'Lista de Examenes', 'roles' => [$role1, $role2, $role3]],
            ['name' => 'admin.examenes.create', 'description' => 'Crear Examen', 'roles' => [$role1, $role2]],
            ['name' => 'admin.examenes.edit', 'description' => 'Editar Examen', 'roles' => [$role1, $role2]],
            ['name' => 'admin.examenes.destroy', 'description' => 'Eliminar Examen', 'roles' => [$role1, $role2]],
            ['name' => 'admin.examenes.show', 'description' => 'Detalles del Examen', 'roles' => [$role1, $role2, $role3]],
            ['name' => 'admin.questions.index', 'description' => 'Mostrar Examen', 'roles' => [$role1, $role2, $role3]],
            ['name' => 'admin.questions.create', 'description' => 'Crear Nueva Pregunta', 'roles' => [$role1, $role2]],
            ['name' => 'admin.questions.edit', 'description' => 'Editar preguntas', 'roles' => [$role1, $role2]],
            ['name' => 'admin.questions.destroy', 'description' => 'Eliminar Pregunta del Examen', 'roles' => [$role1, $role2]],
            ['name' => 'admin.detalleExamen.store','description' => 'Enviar Examen', 'roles' => [$role3]],
        ];

        // Crear los permisos y sincronizarlos con los roles
        foreach ($permissions as $permData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permData['name']],
                ['description' => $permData['description']]
            );
            $permission->syncRoles($permData['roles']);
        }
    }
}
