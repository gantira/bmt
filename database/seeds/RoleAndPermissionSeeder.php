<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'home']);
        Permission::create(['name' => 'simpanan']);
        Permission::create(['name' => 'nasabah']);
        Permission::create(['name' => 'penarikan']);
        Permission::create(['name' => 'pinjaman']);
        Permission::create(['name' => 'roles']);
        Permission::create(['name' => 'laporan']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'nasabah']);
        $role->givePermissionTo('home');

        $role = Role::create(['name' => 'pengelola']);
        $role->givePermissionTo(['penarikan', 'nasabah', 'pinjaman', 'simpanan', 'laporan']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
