<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    //
    public function index(){

        $cities = City::all();
        return response()->json($cities);

    }
}
