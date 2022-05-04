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
                'name' => 'Tokyo',
                'country' => 'Japan',
                'lat' => '35.6748',
                'lon' => '139.7704'
            ]
        );
    }
}
