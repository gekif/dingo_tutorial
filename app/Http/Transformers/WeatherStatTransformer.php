<?php

namespace App\Http\Transformers;

use App\Models\WeatherStats;
use League\Fractal\TransformerAbstract;

class WeatherStatTransformer extends TransformerAbstract
{
    public function transform(WeatherStats $weatherStats)
    {
        return [
            'id' => $weatherStats->id,
            'city_id' => $weatherStats->city_id,
            'city_name' => $weatherStats->city->name,
            'temp_celcius' => $weatherStats->temp_celcius,
            'status' => $weatherStats->status
        ];
    }
}