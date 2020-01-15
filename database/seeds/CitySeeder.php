<?php

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $cities = [
            'London',
            'Paris',
            'Washington'
        ];

        foreach ($cities as $city) {
            City::firstOrCreate([
                'name' => $city
            ]);
        }

        Model::reguard();
    }
}
