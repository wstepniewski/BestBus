<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData();

        foreach($data as $row)
        {
            if(!isset($row[1]))
            {
                continue;
            }
            DB::table('routes')->insert([
                'cityFrom' => $row[1],
                'cityTo' => $row[2],
                'travelTime' => $row[3],
                'carrier_id' => $row[4],
                'price' => $row[5] ?? 0,
            ]);
        }

    }

    private function getData(): array
    {
        $csvData = file_get_contents('database/seedFiles/routes.csv');

        $lines = explode(PHP_EOL, $csvData);
        $array = array();
        foreach($lines as $line)
        {
            $array[] = str_getcsv($line);
        }
        return $array;
    }
}
