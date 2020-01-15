<?php

namespace App\Http\Controllers;

use App\Http\Transformers\WeatherStatTransformer;
use App\Models\City;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueryController extends Controller
{
    public function current($city)
    {
        if (!($city = City::where('name', $city)->first()))
            throw new NotFoundHttpException('Unknown City');


        return $this->response
            ->item($city->weatherStats()
                ->first(),
                new WeatherStatTransformer());

    }


    public function all($city)
    {
        if (!($city = City::where('name', $city)->first()))
            throw new NotFoundHttpException('Unknown City');


        return $this->response
            ->collection($city->weatherStats,
                new WeatherStatTransformer());

    }
}
