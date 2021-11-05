<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WeatherFetcher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_fetcher', function (Blueprint $weather) use ($table) {
            $table->increments('id')->unique;
            $table->string('city');
            $table->int('temperature');
            $table->int('humidity');
            $table->int('pressure');
            $table->round('wind');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_fetcher');
    }
}
