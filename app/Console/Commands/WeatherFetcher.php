<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WeatherFetcher extends Command
{
    private const DEFAULT_PRECISION = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch {cities*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the weather for particular city.';

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $this->output->table(
            ['City', 'Temperature, °C', 'Humidity, %', 'Pressure, mm Hg', 'Wind, m/s'],
            $this->getWeatherDetails()
        );
    }

    /**
     * @throws Exception
     */
    private function getWeatherDetails(): array
    {
        $dataByCities = [];
        foreach ($this->argument('cities') as $city) {
            $url = sprintf(
                'api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric',
                $city,
                env('WEATHER_API_KEY')
            );
            $response = Http::get($url);
            if ($response->status() !== ResponseAlias::HTTP_OK) {
                throw new Exception("Invalid response: {$response->body()}");
            }

            $decodedResponse = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);
            $dataByCities[] = compact('city') + $this->normalizeWeatherDetails($decodedResponse);
        }

        return $dataByCities;
    }

    private function normalizeWeatherDetails(array $weatherData): array
    {
        return [
            'temperature' => (int) $weatherData['main']['temp'],
            'humidity' => (int) $weatherData['main']['humidity'],
            'pressure' => (int) $weatherData['main']['pressure'],
            'wind' => round($weatherData['wind']['speed'], self::DEFAULT_PRECISION),
        ];
    }
}
