<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\City::create(
            [
                'name' => 'London',
                'country' => 'United Kingdom',
                'lat' => '0.1275',
                'lon' => '51.5072'
            ],
            [
                'name' => 'New York',
                'country' => 'United States',
                'lat' => '40.7143',
                'lon' => '-74.006'
            ],[
                'name' => 'Paris',
                'country' => 'France',
                'lat' => '48.8566',
                'lon' => '2.3522'
            ],[
                'name' => 'Berlin',
                'country' => 'Germany',
                'lat' => '13.404954',
                'lon' => '52.520007'
            ],[
                'name' => 'Tokyo',
                'country' => 'Japan',
                'lat' => '139.7704',
                'lon' => '35.6748'
            ]
        );
    }
}
