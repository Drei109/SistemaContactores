<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PuntoVentaPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Listar Puntos de Venta']);
        Permission::create(['name' => 'Crear Puntos de Venta']);
        Permission::create(['name' => 'Editar Puntos de Venta']);
    }
}
