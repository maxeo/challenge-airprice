<?php

namespace Database\Seeders;

use App\Models\Airport\Flight;
use Database\Seeders\Airport\AirportSeeder;
use Database\Seeders\Airport\AirStatSeeder;
use Database\Seeders\Airport\FlightSeeder;
use Database\Seeders\Base\RolesAndPermissionsSeeder;
use Database\Seeders\Base\UserSeeder;
use Database\Seeders\Airport\CalculatorParameterSeeder;
use Database\Seeders\Airport\ConsumableSeeder;
use Database\Seeders\Airport\MachineSeeder;
use Database\Seeders\Airport\PaperSeeder;
use Database\Seeders\Airport\PrintGroupSeeder;
use Database\Seeders\Airport\PrintGroupTypeSeeder;
use Database\Seeders\Airport\ProcessingSeeder;
use Database\Seeders\Airport\ProcessingToMachineSeeder;
use Database\Seeders\Airport\ProcessingTypeSeeder;
use Database\Seeders\Rbac\LaRbacDatabaseSeeder;
use Database\Seeders\Website\WebsiteNavigationGroupSeeder;
use Database\Seeders\Website\WebsiteNavigationSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //Permissions
        $this->call(RolesAndPermissionsSeeder::class);

        //Users
        $this->call(UserSeeder::class);



        //Airport
        $this->call(AirportSeeder::class);
        $this->call(FlightSeeder::class);
        $this->call(AirStatSeeder::class);

        //Website
        $this->call(WebsiteNavigationGroupSeeder::class);
        $this->call(WebsiteNavigationSeeder::class);

    }
}
