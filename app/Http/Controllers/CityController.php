<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SelectedCity;

class CityController extends Controller
{
    public function addCity($name, Request $r){
        $city = new SelectedCity;
        $city->user_id = $r->user()->id;
        $city->city_name = $name;
        $city->save();

        return SelectedCity::where('user_id',$r->user()->id)->get();
        //return response('Unet',200);
    }

    public function getCities(Request $r){
        return SelectedCity::where('user_id',$r->user()->id)->get();
    }

    public function delCity($name, Request $r){
        $city = SelectedCity::where([["city_name", "=", $name],["user_id", "=", $r->user()->id]])->first();
        $city->delete();

        return SelectedCity::where('user_id',$r->user()->id)->get();
    }

    public function show(Request $r=null, $dist){
        return SelectedCity::select($dist)->distinct($dist)->get();
    }

}
