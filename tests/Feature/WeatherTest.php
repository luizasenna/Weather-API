<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class WeatherTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWeatherIndex()
    {
        $response = $this->get('/api/weather');

        $response->assertStatus(200);
    }

    public function testWeatherIndexWithDate()
    {
        $response = $this->get('/api/weather?dt='.now()->format('Y-m-d'));
        $response->assertStatus(200);
    }

    public function testWeatherDateFuture()
    {
        $dt = Carbon::now()->addDays(5)->format('Y-m-d');

        $response = $this->json('GET', '/api/weather', ['dt' => $dt]);

        $response->assertStatus(404)
            ->assertJsonFragment([
                'error' => "Date not found, try another one.",
            ]);
    }

    public function testRequiredFieldsToPost()
    {
        $this->json('POST', 'api/weather', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Validation errors",
                "data" => [
                    "city_id" => ["The city id field is required."],
                    "main" => ["The main field is required."],
                    "description" => ["The description field is required."],
                    "temp" => ["The temp field is required."],
                    "feels_like" => ["The feels like field is required."],
                    "temp_min" => ["The temp min field is required."],
                    "temp_max" => ["The temp max field is required."],
                    "pressure" => ["The pressure field is required."],
                    "humidity" => ["The humidity field is required."],
                    ]
            ]);
    }
}
