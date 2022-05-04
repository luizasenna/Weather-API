<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Models\Weather;
use App\Models\City;
use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{

    public function index(){
        $weather = Weather::all();
        return response()->json($weather);

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

    public function checkIfExists($date){
        $weather = Weather::where('created_at', '=', '$date');

    }

    public static function fromAPI(){

        $cities = City::all();
        try {


            foreach($cities as $city){

                $url = 'https://api.openweathermap.org/data/2.5/weather?lat='.$city->lat.'&lon='.$city->lon.'&appid=3afc7a17d7a1ee160a9b766dfbcfb83b';

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
                        'humidity' => $capture->main->humidity
                        ));
                


            }


          } catch(\Exception $e){
                return $e->getMessage();

            }

    }
}
