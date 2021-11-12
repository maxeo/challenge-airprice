<?php

namespace Database\Seeders\Website;

use App\Models\Website\WebsiteNavigationGroup;
use Illuminate\Database\Seeder;

class WebsiteNavigationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsiteNavigationGroup::create([
            'name' => 'Base',
            'position' => 1,
        ]);

        WebsiteNavigationGroup::create([
            'name' => 'Preventivi',
            'position' => 2,
        ]);

        WebsiteNavigationGroup::create([
            'name' => 'Utenti e Permessi',
            'position' => 1000,
        ]);
    }
}
