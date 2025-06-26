<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmbassieesController;
use App\Http\Controllers\AirportsController;
use App\Http\Controllers\AircharterController;
use App\Http\Controllers\MasterairportController;
use App\Http\Controllers\MasterhospitalController;
use App\Http\Controllers\MasterembessyController;
use App\Http\Controllers\MasteraircharterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('home', [App\Http\Controllers\HomeController::class, 'index']);
Route::resource('hospital', HospitalController::class);
Route::get('/api/hospitals', [HospitalController::class, 'api']);
Route::get('/hospitals/{id}', [HospitalController::class, 'showdetail']);
Route::get('/hospitals/clinic/{id}', [HospitalController::class, 'showdetailclinic']);
Route::get('/hospitals/emergency/{id}', [HospitalController::class, 'showdetailemergency']);
Route::resource('embassiees', EmbassieesController::class);
Route::get('/api/embassiees', [EmbassieesController::class, 'api']);
Route::get('/embassiees/{id}/detail', [EmbassieesController::class, 'showdetail']);
Route::resource('airports', AirportsController::class);
Route::get('/api/airports', [AirportsController::class, 'api']);
Route::get('/airports/{id}/detail', [AirportsController::class, 'showdetail']);
Route::get('/airports/{id}/emergency', [AirportsController::class, 'showdetailemergency']);
Route::resource('aircharter', AircharterController::class);
Route::get('/airports/{id}/airlinesdestination', [AirportsController::class, 'showairlinesdestination']);
Route::get('/airports/{id}/navigation', [AirportsController::class, 'shownavigation']);
Route::get('/api/airports', [AirportsController::class, 'filter']);
Route::get('/api/embassy', [EmbassieesController::class, 'filter']);
Route::get('/api/hospital', [HospitalController::class, 'filter']);

Route::resource('airportdata', MasterairportController::class);
Route::resource('hospitaldata', MasterhospitalController::class);
Route::resource('embessydata', MasterembessyController::class);
Route::resource('aircharterdata', MasteraircharterController::class);
