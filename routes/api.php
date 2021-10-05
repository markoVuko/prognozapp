<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*

T- dailyReports
cityName, country, weatherName, weatherDesc, tempMin, tempMax, date


T- userCities
id, userId, cityName

*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/reports', [App\Http\Controllers\ReportController::class, 'store']);
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index']);

Route::get('/cities/{dist}', [App\Http\Controllers\CityController::class, 'show']);

Route::get('/users', [App\Http\Controllers\UserController::class, 'show']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);

