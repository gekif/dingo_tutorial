<?php

namespace App\Services;

use App\Models\WeatherStats;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class OpenWeatherMapService
{
    public function query(string $apiKey, Collection $cities) : Collection
    {
        $result = collect();


        $guzzleClient = new Client([
            'base_uri' => 'http://api.openweathermap.org',
        ]);


        foreach ($cities as $city) {
            $response = $guzzleClient->get('data/2.5/weather', [
                'query' => [
                    'units' => 'metric',
                    'APPID' => $apiKey,
                    'q' => $city->name
                ]
            ]);

            $response = json_decode($response->getBody()->getContents(), true);

            $stat = new WeatherStats();

            $stat->city()->associate($city);
            $stat->temp_celcius = $response['main']['temp'];
            $stat->status = $response['weather'][0] ? $response['weather'][0]['main'] : '';
            $stat->last_update = Carbon::createFromTimestamp($response['dt']);
            $stat->provider = 'openweathermap.com';

            $stat->save();

            $result->push($stat);

        }

        return $result;
    }
}