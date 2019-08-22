<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'Listar Puntos de Venta']);
        Permission::create(['name' => 'Crear Puntos de Venta']);
        Permission::create(['name' => 'Editar Puntos de Venta']);

        Permission::create(['name' => 'Listar Destinatarios']);
        Permission::create(['name' => 'Crear Destinatarios']);
        Permission::create(['name' => 'Editar Destinatarios']);

        Permission::create(['name' => 'Listar Reportes']);

        Permission::create(['name' => 'Configurar Usuarios']);
        Permission::create(['name' => 'Configurar Roles']);
        Permission::create(['name' => 'Configurar Permisos']);
    }
}
