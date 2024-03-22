<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\ConventionnalHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\HypothecStepController;

/*
|--------------------------------------------------------------------------
| Guarantee API Routes
|--------------------------------------------------------------------------
*/

//conventionnal hypothec
Route::get('/conventionnal_hypotec/steps', [HypothecStepController::class, ]);
Route::post('/conventionnal_hypothec/update/{convHypo}', array(ConventionnalHypothecController::class, 'updateProcess'));
Route::resource('/conventionnal_hypothec', ConventionnalHypothecController::class);
