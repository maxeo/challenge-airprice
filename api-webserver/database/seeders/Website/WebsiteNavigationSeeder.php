<?php

namespace Database\Seeders\Website;

use App\Models\Website\WebsiteNavigation;
use App\Models\Website\WebsiteNavigationGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class WebsiteNavigationSeeder extends Seeder
{

    const ADMIN_PREFIX = '/administration';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Base

        WebsiteNavigation::create([
            'title' => 'Dashboard',
            'link' => 'admin-dashboard',
            'icon' => 'fas fa-sliders-h',
            'position' => 1,
            'group_id' => WebsiteNavigationGroup::where('name', 'Base')->first()->id,
            'permission_id' => Permission::where('name', 'dashboard/menu')->first()->id,
        ]);

        // Voli e Aeroporti

        WebsiteNavigation::create([
            'title' => 'Gestione Aeroporti',
            'link' => 'parametri-aeroporti',
            'icon' => 'fas fa-plane',
            'position' => 100,
            'group_id' => WebsiteNavigationGroup::where('name', 'Voli e Aeroporti')->first()->id,
            'permission_id' => Permission::where('name', 'airports/airports-manage/menu')->first()->id,
        ]);

        WebsiteNavigation::create([
            'title' => 'Gestione Voli',
            'link' => 'parametri-voli',
            'icon' => 'fas fa-plane-departure',
            'position' => 100,
            'group_id' => WebsiteNavigationGroup::where('name', 'Voli e Aeroporti')->first()->id,
            'permission_id' => Permission::where('name', 'airports/flights-manage/menu')->first()->id,
        ]);



        // Utenti
        WebsiteNavigation::create([
            'title' => 'Gestione Utenti',
            'link' => 'admin-gestione-utenti',
            'icon' => 'fad fa-user',
            'position' => 100,
            'group_id' => WebsiteNavigationGroup::where('name', 'Utenti e Permessi')->first()->id,
            'permission_id' => Permission::where('name', 'users-manage/menu')->first()->id,
        ]);
        WebsiteNavigation::create([
            'title' => 'Gestione Ruoli',
            'link' => 'admin-gestione-ruoli',
            'icon' => 'fad fa-users',
            'position' => 101,
            'group_id' => WebsiteNavigationGroup::where('name', 'Utenti e Permessi')->first()->id,
            'permission_id' => Permission::where('name', 'roles-manage/menu')->first()->id,
        ]);
        WebsiteNavigation::create([
            'title' => 'Gestione Permessi',
            'link' => 'admin-gestione-permessi',
            'icon' => 'fad fa-key',
            'position' => 102,
            'group_id' => WebsiteNavigationGroup::where('name', 'Utenti e Permessi')->first()->id,
            'permission_id' => Permission::where('name', 'permissions-manage/menu')->first()->id,
        ]);


    }
}
