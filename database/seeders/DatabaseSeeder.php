<?php

namespace Database\Seeders;

use App\Models\RestaurantGenle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RestaurantsTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(GenlesTableSeeder::class);
        $this->call(RestaurantGenlesTableSeeder::class);
    }
}
