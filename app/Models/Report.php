<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /*'city_name',
        'country',
        'weather_name',
        'weather_desc',
        'temp_min',
        'temp_max',
        'humidity',
        'pressure',
        'logged_at',*/

    protected $fillable = [
        'city_name',
        'country',
        'weather_name',
        'weather_desc',
        'temp_min',
        'temp_max',
        'humidity',
        'pressure',
        'dt_txt',
        'created_at',
    ];
    protected $table = "reports";
}
