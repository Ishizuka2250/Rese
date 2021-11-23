<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Common\ReadCSV;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurantMaster = ReadCSV::import_csv('database/master/restaurants.csv');
        foreach($restaurantMaster as $record) {
            Restaurant::updateOrCreate(['name' => $record['name']], $record);
        }
    }
}
