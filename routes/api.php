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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cities', [CitiesController::class, 'index']);
Route::get('/try', [WeatherController::class, 'fromAPI']);

Route::get('popul', function () {
    dispatch(new \App\Jobs\StoreDataJob());
});

Route::group(['prefix' => 'weather'], function() {
    Route::get('', [WeatherController::class, 'index']);
    Route::post('', [WeatherController::class, 'store']);
    Route::get('{id}', [WeatherController::class, 'show']);
    Route::put('{id}', [WeatherController::class, 'update']);
    Route::delete('{id}', [WeatherController::class, 'destroy']);



});

