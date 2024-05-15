<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecStepController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecTaskController;
use App\Http\Controllers\API\V1\Guarantee\GuaranteeController;
use App\Http\Controllers\API\V1\Guarantee\GuaranteeTaskController;

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
    Route::put('/conventionnal_hypothec/tasks/transfer/{task_id}', [ConvHypothecTaskController::class, 'transfer']);
    Route::post('/conventionnal_hypothec/tasks/complete/{task}', [ConvHypothecTaskController::class, 'complete']);
    Route::resource('/conventionnal_hypothec/tasks', ConvHypothecTaskController::class);
    Route::post('/conventionnal_hypothec/update/{convHypo}', array(ConvHypothecController::class, 'updateProcess'));
    Route::post('/conventionnal_hypothec/realization/{conv_hypo}', array(ConvHypothecController::class, 'realization'));
    Route::resource('/conventionnal_hypothec', ConvHypothecController::class);

    Route::put('/guarantees/tasks/transfer/{task_id}', [GuaranteeTaskController::class, 'transfer']);
    Route::post('/guarantees/tasks/complete/{task}', [GuaranteeTaskController::class, 'complete']);
    Route::resource('/guarantees/tasks', GuaranteeTaskController::class);
    Route::post('/guarantees/realization/{guarantee}', [GuaranteeController::class, 'realization']);
    Route::resource('/guarantees', GuaranteeController::class);
});
