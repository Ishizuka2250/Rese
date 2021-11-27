<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('detail')->nullable(false);
            $table->string('image_file_name')->nullable(false);
            $table->unsignedBigInteger('area_id')->nullable(false);
            $table->time('open_time')->nullable(false);
            $table->time('close_time')->nullable(false);
            $table->unsignedInteger('max_reserve')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
