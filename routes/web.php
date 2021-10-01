<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/getInfo', [App\Http\Controllers\HomeController::class, 'getInfo']);

Route::post('/cities/{name}', [App\Http\Controllers\CityController::class, 'addCity']);
Route::get('/cities', [App\Http\Controllers\CityController::class, 'getCities']);
Route::delete('/cities/{name}', [App\Http\Controllers\CityController::class, 'delCity']);
