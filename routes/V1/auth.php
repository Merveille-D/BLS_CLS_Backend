<?php

use App\Http\Controllers\Auth\CountryController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

//countries resource

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('subsidiaries', CountryController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/current-user', [UserController::class, 'current']);
    Route::resource('users', UserController::class);
    Route::post('logout',[UserController::class,'logout']);
});

