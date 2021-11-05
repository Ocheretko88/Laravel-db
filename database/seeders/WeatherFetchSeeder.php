<?php

namespace Database\Seeders;

use App\Models\Weather;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeatherFetchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Weather::class);
    }

}
