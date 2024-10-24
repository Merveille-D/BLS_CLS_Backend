<?php

use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\NotificationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::put('notifications/remind_later/{id}', [NotificationController::class, 'remindLater']);
    Route::resource('notifications', NotificationController::class);
});

Route::get('trigger_module_alert', [AlertController::class, 'triggerModuleAlert']);

Route::get('queue-cmd', function () {
    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
    ]);

    return 'Commande queue executée avec succès!';
});
