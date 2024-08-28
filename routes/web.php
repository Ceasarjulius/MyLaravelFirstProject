<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExaController;
use App\Http\Controllers\UserController;

Route::get('/about',[ExaController::class,'aboutPage']);
Route::get('/',[UserController::class,'showCorrectHomePage']);

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
