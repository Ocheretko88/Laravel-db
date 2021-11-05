<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Weather extends Model
{
    use HasFactory;
    public static $cities = [
        'Kyiv',
        'Berlin',
        'Mexico',
        'Dublin'
    ];
    public function run(): void
    {
        foreach (self::$cities as $city) {
            DB::table('cities')->insert([
                'id' => str_random(10),
                'city' => $city,
            ]);
            DB::table('weather_fetcher')->insert([
                'id' => str_random(10),
                'city' => $city,
                'temperature' => $this->str_random(10),
                'humidity' => $this->str_random(10),
                'pressure' => $this->str_random(10),
                'wind' => $this->str_random(10)
            ]);
        }
    }

}
