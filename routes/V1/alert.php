<?php

use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('notifications', NotificationController::class);
Route::resource('alerts', AlertController::class);
