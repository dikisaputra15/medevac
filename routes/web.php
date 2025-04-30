<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmbassieesController;
use App\Http\Controllers\AirportsController;
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

Route::get('/', function () {
    return view('welcome');
});

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
