<?php

namespace Database\Seeders;

use App\Common\ReadCSV;
use App\Models\Genle;
use Illuminate\Database\Seeder;

class GenlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genleMaster = ReadCSV::import_csv('database/master/genles.csv');
        foreach($genleMaster as $record) {
            Genle::updateOrCreate(['genle' => $record['genle']], $record);
        }
    }
}
