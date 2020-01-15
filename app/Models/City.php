<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function weatherStats()
    {
        return $this->hasMany(WeatherStats::class);
    }
}
