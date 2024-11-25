<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesCertificadosSeeder extends Seeder
{
    public function run()
    {
        // Crear rol (asegúrate de que el rol no exista previamente)
        $role1 = Role::firstOrCreate(['name' => 'Administrador']); 

        // Crear permisos para certificados y asignarlos al rol
        $permissions = [
            [
                'name' => 'admin.certificados.index',
                'description' => 'Ver lista de Certificados',
            ],
            [
                'name' => 'admin.certificados.create',
                'description' => 'Crear Certificados',
            ],
            [
                'name' => 'admin.certificados.edit',
                'description' => 'Editar Certificados',
            ],
        ];

        foreach ($permissions as $permissionData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['description' => $permissionData['description']]
            );

            // Sincronizar permisos con el rol
            $permission->syncRoles([$role1]);
        }
    }
}
