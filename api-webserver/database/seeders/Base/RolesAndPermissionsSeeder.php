<?php

namespace Database\Seeders\Base;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard/menu']);
        Permission::create(['name' => 'dashboard/view']);

        Permission::create(['name' => 'support/menu']);
        Permission::create(['name' => 'support/view']);

        Permission::create(['name' => 'profile/menu']);
        Permission::create(['name' => 'profile/view']);
        Permission::create(['name' => 'profile/update']);


        //# Airport

        //#User and permission manage
        Permission::create(['name' => 'users-manage/menu']);
        Permission::create(['name' => 'users-manage/view']);
        Permission::create(['name' => 'users-manage/list']);
        Permission::create(['name' => 'users-manage/update']);
        Permission::create(['name' => 'users-manage/add']);
        Permission::create(['name' => 'users-manage/delete']);

        Permission::create(['name' => 'roles-manage/menu']);
        Permission::create(['name' => 'roles-manage/view']);
        Permission::create(['name' => 'roles-manage/list']);
        Permission::create(['name' => 'roles-manage/update']);
        Permission::create(['name' => 'roles-manage/add']);
        Permission::create(['name' => 'roles-manage/delete']);

        Permission::create(['name' => 'permissions-manage/menu']);
        Permission::create(['name' => 'permissions-manage/view']);
        Permission::create(['name' => 'permissions-manage/list']);
        Permission::create(['name' => 'permissions-manage/update']);
        Permission::create(['name' => 'permissions-manage/add']);
        Permission::create(['name' => 'permissions-manage/delete']);


        // admin
        $role_admin = Role::create(['name' => 'Amministratore']);
        $role_admin->givePermissionTo([
            'dashboard/menu',
            'dashboard/view',
            'support/menu',
            'support/view',
            'profile/menu',
            'profile/view',
            'profile/update',
        ]);

        // super-admin
        $role_superadmin = Role::create(['name' => 'Super Amministratore']);
        $role_superadmin->givePermissionTo(Permission::all());

    }
}
