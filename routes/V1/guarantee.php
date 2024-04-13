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
Route::get('/conv-hypothec/steps/{id}',  [ConvHypothecController::class, 'showSteps']);
Route::post('/conventionnal_hypothec/update/{convHypo}', array(ConventionnalHypothecController::class, 'updateProcess'));
Route::resource('/conventionnal_hypothec', ConvHypothecController::class);
