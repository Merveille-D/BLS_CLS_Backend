<?php

use App\Http\Controllers\Auth\CountryController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/current-user', [UserController::class, 'current']);
Route::resource('users', UserController::class);

//roles resource
Route::resource('roles', RoleController::class);

//countries resource
Route::resource('countries', CountryController::class);

