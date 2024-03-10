<?php

use App\Http\Controllers\Flight_Crud_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Models\User;

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
// Route::get('/flights', [FlightController::class, 'index']);
// Route::get('/passengers',[PassengerController::class,'index']);
// Route::get('/flights/{flight}/passengers', [FlightController::class, 'show']);

Route::resource('flights', FlightController::class);
Route::resource('passengers',PassengerController::class);
Route::get('/users/{id}',[UserController::class,'show']);
Route::post('/users', [UserController::class, 'addUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::fallback(function () {
    return view('welcome');
});