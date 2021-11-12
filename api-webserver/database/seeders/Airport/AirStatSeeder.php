<?php

namespace Database\Seeders\Airport;

use App\Models\Airport\AirStat;
use Illuminate\Database\Seeder;

class AirStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AirStat::create([
            'key_name' => 'search_counter',
            'key_value' => '0',
        ]);

        AirStat::create([
            'key_name' => 'book_counter',
            'key_value' => '0',
        ]);


    }
}
