<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class UserController extends Controller
{
    public function index(Request $r){
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

    public function show(Request $r, $id){
        $user = User::find($id);
        $uRes = new stdClass;
        $cities = $user->selectedCities;
        $cityNames = [];
        foreach ($cities as $city) {
            array_push($cityNames, $city->city_name);
        }
        $uRes->user = $user->email;
        $uRes->cities = $cityNames;

        return $uRes;
    }

    public function update(Request $r, $id){
        $user = User::find($id);
        $user->update($r->all());
    }
}
