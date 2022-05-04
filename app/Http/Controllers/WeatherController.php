<?php

namespace App\Http\Controllers;

use App\Events\NewDateWeatherEvent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Models\Weather;
use App\Models\City;
use Illuminate\Support\Facades\Http;
use DateTime;
use Carbon\Carbon;


class WeatherController extends Controller
{

    public function index(Request $request){

        If(empty($request->dt)) {
            $weather = Weather::all();
            return response()->json($weather);
        }
         else {
             $newdate = Carbon::parse($request->dt)->format('Y-m-d H:i:s');
             $weather = Weather::where('dt', '=', $newdate)->get();

             if( $weather->count() > 0 ){

                 $weather = Weather::where('dt', '=', $newdate)->get();
                 return response()->json($weather, status: 200);

             } else {
                 if (event(new NewDateWeatherEvent($request->dt))) {

                     $weather = Weather::where('dt', '=', $newdate)->get();

                     if ($weather->count()) {
                         return response()->json($weather, status: 200);
                     }

                 }
                 return response()->json(['error' => 'Date not found, try another one.'], status: 404);
             }
        }
    }
    public function store(StoreRequest $request){

        return response()->json(
            Weather::create($request->all()),
            status: 201
        );
    }

    public function show(int $id){
        $resource = Weather::find($id);
        if(is_null($resource)){
            return response()->json('', status: 204);
        }
        return response()->json($resource);
    }

    public function update(int $id, Request $request){
        $resource = Weather::find($id);
        if( is_null($resource)){
            return response()->json('Not Found', status: 404);
        }
        $resource->fill($request->all());
        $resource->save();
        return response()->json($resource);
    }

    public function destroy(int $id){
        $qtRemovedResources = Weather::destroy($id);
        if ($qtRemovedResources === 0 ){
            return response()
                ->json(['error' => 'Resource not found'], status: 404);
        }

        return response()->json('Removed', status: 204);
    }

    public static function currentFromAPI(){

        $cities = City::all();
        try {
            foreach($cities as $city){
                $url = 'https://api.openweathermap.org/data/2.5/weather?lat='.$city->lat.'&lon='.$city->lon.'&appid='.env('WEATHER_ID');

                $response = Http::get($url);
                $capture = json_decode($response->body());
                $weather = Weather::create(
                    array('city_id' => $city->id,
                        'main' => $capture->weather[0]->main,
                        'description' => $capture->weather[0]->description,
                        'temp' => $capture->main->temp,
                        'feels_like' => $capture->main->feels_like,
                        'temp_min' => $capture->main->temp_min,
                        'temp_max' => $capture->main->temp_max,
                        'pressure' => $capture->main->pressure,
                        'humidity' => $capture->main->humidity,
                        'dt' => $capture->dt
                        ));
            }
          } catch(\Exception $e){
                return $e->getMessage();
            }
    }

    public static function otherDateFromAPI($dt){

        $cities = City::all();
        $dateTime = new DateTime($dt);
        $timestamp = $dateTime->format('U');

        try {
            foreach($cities as $city){
                $url = 'https://api.openweathermap.org/data/2.5/onecall/timemachine?lat='.$city->lat.'&lon='.$city->lon.'&dt='.$timestamp.'&appid='.env('WEATHER_ID');
                $response = Http::get($url);

                if($response->status() == '200') {
                    $capture = json_decode($response->body());

                    $newdt = Carbon::parse($capture->current->dt)->format('Y-m-d H:i:s');

                    $weather = Weather::create(
                        array('city_id' => $city->id,
                            'main' => $capture->current->weather[0]->main,
                            'description' => $capture->current->weather[0]->description,
                            'temp' => $capture->current->temp,
                            'feels_like' => $capture->current->feels_like,
                            'temp_min' => ($capture->current->temp_min ?? ' '),
                            'temp_max' => ($capture->current->temp_max ?? ' '),
                            'pressure' => $capture->current->pressure,
                            'humidity' => $capture->current->humidity,
                            'dt' => $newdt
                        ));
                } else {
                    return json_decode($response->body());
                }
            }
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
