<?php

namespace Database\Seeders;

use App\Common\ReadCSV;
use App\Models\RestaurantGenle;
use Illuminate\Database\Seeder;

class RestaurantGenlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurantGenleMaster = ReadCSV::import_csv('database/master/restaurant_genles.csv');
        foreach($restaurantGenleMaster as $record) {
            RestaurantGenle::updateOrCreate([
                'restaurant_id' => $record['restaurant_id'],
                'genle_id' => $record['genle_id']
            ], $record);
        }
    }
}
