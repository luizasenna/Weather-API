<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{

    public function index(){

        $weather = Weather::all();
        return response()->json($weather);

    }
    public function store(Request $request){
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
}
