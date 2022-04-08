<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            'day'=>'21.08.22',
            'departure'=> '14:30',
            'arrival'=> '20:40',
            'price'=> 123.7,
            'cityFrom' => 'Kraków',
            'cityTo'=> 'Amsterdam',
            'traveler'=>'witek',
            'user_id'=>38,
            'carrier_id'=>1,
        ]);
    }
}


