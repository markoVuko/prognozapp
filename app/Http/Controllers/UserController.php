<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $r){
        $users = User::select()->get();
        $arr=[];
        foreach ($users as $u) {
            $cities = $u->selectedCities;
            $cityNames = [];
            foreach ($cities as $city) {
                array_push($cityNames, $city->city_name);
            }
            array_push($arr, ["user" => $u->email, "cities" => $cityNames]);
        }

        return $arr;
    }
}
