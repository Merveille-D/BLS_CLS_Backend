<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecStepController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecTaskController;

/*
|--------------------------------------------------------------------------
| Guarantee API Routes
|--------------------------------------------------------------------------
*/

//conventionnal hypothec
// Route::resource('/conv-hypothec/steps', ConvHypothecStepController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/conv-hypothec/steps/{id}',  [ConvHypothecController::class, 'showSteps']);
    Route::get('/conv-hypothec/steps/{id}/{step_id}',  [ConvHypothecController::class, 'showOneStep']);
    Route::put('/conventionnal_hypothec/transfer/{task_id}', [ConvHypothecTaskController::class, 'transfer']);
    Route::resource('/conventionnal_hypothec/tasks', ConvHypothecTaskController::class);
    Route::post('/conventionnal_hypothec/update/{convHypo}', array(ConvHypothecController::class, 'updateProcess'));
    Route::post('/conventionnal_hypothec/realization/{conv_hypo}', array(ConvHypothecController::class, 'realization'));
    Route::resource('/conventionnal_hypothec', ConvHypothecController::class);
});
