<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        $cities = [[]];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
