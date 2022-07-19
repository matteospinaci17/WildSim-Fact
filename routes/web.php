<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::get('/', 'App\Http\Controllers\GameController@LoadHomepage');
Route::post('/start-session', 'App\Http\Controllers\GameController@StartSession');
Route::post('/next-step', 'App\Http\Controllers\GameController@NextStep');
Route::post('/save-session', 'App\Http\Controllers\GameController@StopSession');
Route::post('/restore-session', 'App\Http\Controllers\GameController@RestoreSession');
Route::post('/calculate-factorial', 'App\Http\Controllers\FactorialController@CalculateFactorialWrapper');
