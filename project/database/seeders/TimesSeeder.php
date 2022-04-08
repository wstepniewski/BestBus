<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesSeeder extends Seeder
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
            DB::table('times')->insert([
                'route_id' => $row[0],
                'departure' => $row[1],
            ]);
        }
    }

    private function getData(): array
    {
        $csvData = file_get_contents('database/seedFiles/times.csv');

        $lines = explode(PHP_EOL, $csvData);
        $array = array();
        foreach($lines as $line)
        {
            $array[] = str_getcsv($line);
        }
        return $array;
    }
}
