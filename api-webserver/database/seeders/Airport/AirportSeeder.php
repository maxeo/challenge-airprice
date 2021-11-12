<?php

namespace Database\Seeders\Airport;

use App\Models\Airport\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Airport::create([
            'name' => 'Roma',
            'code' => 'ROM',
            'lat' => '41.91862525966819',
            'lng' => '12.290841516345385',
        ]);

        Airport::create([
            'name' => 'Lisbona',
            'code' => 'LIS',
            'lat' => '38.761609958137484',
            'lng' => '-9.083800528530189',
        ]);

        Airport::create([
            'name' => 'Madrid',
            'code' => 'MAD',
            'lat' => '40.46169085896337',
            'lng' => '-3.7414792637791794',
        ]);

        Airport::create([
            'name' => 'Parigi',
            'code' => 'PAR',
            'lat' => '48.840176230044065',
            'lng' => '2.3325512765101064',
        ]);

        Airport::create([
            'name' => 'Londra',
            'code' => 'LON',
            'lat' => '51.51861727749719',
            'lng' => '-0.21275337208072212',
        ]);

        Airport::create([
            'name' => 'Bruxelles',
            'code' => 'BRU',
            'lat' => '50.84964599032778',
            'lng' => '4.385367149068407',
        ]);

        Airport::create([
            'name' => 'Amsterdam',
            'code' => 'AMS',
            'lat' => '52.40511711701549',
            'lng' => '4.8414569526914955',
        ]);

        Airport::create([
            'name' => 'Berlino',
            'code' => 'BER',
            'lat' => '52.54228366616741',
            'lng' => '13.319461833557037',
        ]);


    }
}
