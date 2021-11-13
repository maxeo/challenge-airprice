<?php

namespace Database\Seeders\Base;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $user = User::create([
//            'first_name' => 'Matteo',
//            'last_name' => 'Burbui',
//            'username' => "superadmin",
//            'email' => 'info@maxeo.net',
//            'email_verified_at' => now(),
//            'password' => Hash::make('super'),
//            'remember_token' => Str::random(10),
//        ]);
//        $user->syncRoles(['Super Amministratore']);


        $user = User::create([
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'username' => "admin",
            'email' => 'admin@maxeo.net',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ]);
        $user->syncRoles(['Amministratore']);

        //User::factory(30)->create();
    }
}
