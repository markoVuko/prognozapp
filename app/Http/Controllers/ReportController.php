<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function store(Request $r){
        $forecast = $r->get('forecast');
        return Report::create([
            'city_name' => $forecast['city_name'],
            'country' => $forecast['country'],
            'weather_name' => $forecast['weather_name'],
            'weather_desc' => $forecast['weather_desc'],
            'temp_min' => $forecast['temp_min'],
            'temp_max' => $forecast['temp_max'],
            'humidity' => $forecast['humidity'],
            'pressure' => $forecast['pressure'],
            'dt_txt' => $forecast['dt_txt']
        ]);
    }

    public function index(Request $r){
        $q = Report::select();
        $niz = $r->get('city_name');
        if($niz != null){
            $q->whereDate('created_at',Carbon::today())->where(function($t) use($niz){
                $t->where('city_name','=',$niz[0]);
                for($i = 1; $i < count($niz); $i++){
                    $t->orWhere('city_name', '=', $niz[$i]);
                }
            });
    
            
            return $q->get();
        } else {
            return Report::get();
        }

        
        
    }
}

/*
$forecast->city_name = $content["city"]["name"];
                $forecast->country = $content["city"]["country"];
                $forecast->weather_name = $arrFore[$i]["weather"][0]["main"];
                $forecast->weather_desc = $arrFore[$i]["weather"][0]["description"];
                $forecast->temp_min = $arrFore[$i]["main"]["temp_min"];
                $forecast->temp_max= $arrFore[$i]["main"]["temp_max"];
                */