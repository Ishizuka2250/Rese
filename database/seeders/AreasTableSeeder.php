<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Common\ReadCSV;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areaMaster = ReadCSV::import_csv('database/master/areas.csv');
        foreach($areaMaster as $record) {
            Area::updateOrCreate(['area' => $record['area']], $record);
        }
    }
}
