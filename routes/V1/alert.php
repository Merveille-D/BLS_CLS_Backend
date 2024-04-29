<?php

use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::put('notifications/remind_later/{id}', [NotificationController::class, 'remindLater']);
Route::resource('notifications', NotificationController::class);
// Route::resource('alerts', AlertController::class);
Route::get('trigger_module_alert', [AlertController::class, 'triggerModuleAlert'] );
