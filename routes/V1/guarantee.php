<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\ConventionnalHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\HypothecStepController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConvHypothecStepController;

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
    Route::post('/conventionnal_hypothec/update/{convHypo}', array(ConvHypothecController::class, 'updateProcess'));
    Route::post('/conventionnal_hypothec/realization/{conv_hypo}', array(ConvHypothecController::class, 'realization'));
    Route::resource('/conventionnal_hypothec', ConvHypothecController::class);
});
