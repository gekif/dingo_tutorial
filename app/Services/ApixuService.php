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
            'base_url' => 'http://api.weatherstack.com',
        ]);


        foreach ($cities as $city) {
            $response = $guzzleClient->get('v1/current.json', [
                'query' => [
                    'key' => $apiKey,
                    'q' => $city->name
                ]
            ]);

            $response = json_decode($response->getBody()->getContents(), true);

            $stat = new WeatherStats();

            $stat->city()->associate($city);
            $stat->temp_celcius = $response['current']['temp_c'];
            $stat->status = $response['current']['condition']['text'];
            $stat->last_update = Carbon::createFromTimestamp($response['current']['last_updated_epoch']);
            $stat->provider = 'weathermap.com';

            $stat->save();

            $result->push($stat);

        }

        return $result;
    }
}