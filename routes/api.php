<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/cities', [CitiesController::class, 'index']);
Route::get('/try', [WeatherController::class, 'currentFromAPI']);
Route::get('/old', [WeatherController::class, 'otherDateFromAPI']);

Route::get('popul', function () {
    dispatch(new \App\Jobs\StoreCurrentDataJob());
});

Route::apiResource('weather', WeatherController::class);


