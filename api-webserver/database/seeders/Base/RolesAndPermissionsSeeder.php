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

        Permission::create(['name' => 'airports/airports-manage/menu']);
        Permission::create(['name' => 'airports/airports-manage/view']);
        Permission::create(['name' => 'airports/airports-manage/list']);
        Permission::create(['name' => 'airports/airports-manage/update']);
        Permission::create(['name' => 'airports/airports-manage/add']);
        Permission::create(['name' => 'airports/airports-manage/delete']);

        Permission::create(['name' => 'airports/flights-manage/menu']);
        Permission::create(['name' => 'airports/flights-manage/view']);
        Permission::create(['name' => 'airports/flights-manage/list']);
        Permission::create(['name' => 'airports/flights-manage/update']);
        Permission::create(['name' => 'airports/flights-manage/add']);
        Permission::create(['name' => 'airports/flights-manage/delete']);


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
            'airports/airports-manage/menu',
            'airports/airports-manage/view',
            'airports/airports-manage/list',
            'airports/airports-manage/update',
            'airports/airports-manage/add',
            'airports/airports-manage/delete',
            'airports/flights-manage/menu',
            'airports/flights-manage/view',
            'airports/flights-manage/list',
            'airports/flights-manage/update',
            'airports/flights-manage/add',
            'airports/flights-manage/delete',
        ]);

        // super-admin
        $role_superadmin = Role::create(['name' => 'Super Amministratore']);
        $role_superadmin->givePermissionTo(Permission::all());

    }
}
