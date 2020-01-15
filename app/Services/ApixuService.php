<?php

namespace App\Services;

use App\Models\WeatherStats;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class ApixuService
{
    public function query(string $apiKey, Collection $cities) : Collection
    {
        $result = collect();


        $guzzleClient = new Client([
            'base_uri' => 'http://api.weatherstack.com',
        ]);


        foreach ($cities as $city) {
            $response = $guzzleClient->get('current', [
                'query' => [
                    'access_key' => $apiKey,
                    'query' => $city->name
                ]
            ]);

            $response = json_decode($response->getBody()->getContents(), true);

            $stat = new WeatherStats();

            $stat->city()->associate($city);
            $stat->temp_celcius = sprintf("%.2f", $response['current']['temperature']);
            $stat->status = $response['current']['weather_descriptions'][0] ? $response['current']['weather_descriptions'][0] : "";
            $stat->last_update = Carbon::createFromTimestamp($response['location']['localtime_epoch']);
            $stat->provider = 'weatherstack.com';

            $stat->save();

            $result->push($stat);

        }

        return $result;

//        return var_dump($result);
    }
}