<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\Auth\LoginController;

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
})->name('login');;
// Route::get('/flights', [FlightController::class, 'index']);
// Route::get('/passengers',[PassengerController::class,'index']);
// Route::get('/flights/{flight}/passengers', [FlightController::class, 'show']);

Route::resource('flights', FlightController::class);//->middleware('auth');
Route::resource('passengers',PassengerController::class);
Route::get('/users/{user}',[UserController::class,'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/login', [LoginController::class, 'login']);
Route::fallback(function () {
    return view('welcome');
});