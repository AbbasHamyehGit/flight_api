<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\API\ImportController;
use App\Http\Controllers\ImageController;
Route::get('/images',[ImageController::class,'index']);
Route::post('/images',[ImageController::class,'store'])->name('image.store');