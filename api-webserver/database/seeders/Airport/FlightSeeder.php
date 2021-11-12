<?php

namespace Database\Seeders\Airport;

use App\Models\Airport\Airport;
use App\Models\Airport\Flight;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = Airport::all('code');

        foreach ($codes as $code_departure) {
            foreach ($codes as $code_arrival) {
                if ($code_departure->code !== $code_arrival->code) {
                    Flight::create([
                        'code_departure' => $code_departure->code,
                        'code_arrival' => $code_arrival->code,
                        'price' => rand(30 * 100, 500 * 100) / 100,
                    ]);
                }
            }
        }


    }
}
