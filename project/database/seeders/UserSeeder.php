<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basicName = 'carrier';
        $nCarriers = 37; // wpisane z palca -> bierze się z pliku routes.csv

        for($index = 0; $index < $nCarriers; $index++)
        {
            DB::table('users')->insert([
                'name' => $basicName.$index,
                'email' => $basicName.$index.'@gmail.com',
                'password' => bcrypt('secret'),
                'isCarrier' => 1,
                'balance' =>0.0,
            ]);
        }

        DB::table('users')->insert([
            'name' => 'witek',
            'email' => 'witek@wp.pl',
            'password' => bcrypt('polska123'),
            'isCarrier' => 0,
            'balance' =>120.5,
        ]);
    }
}


