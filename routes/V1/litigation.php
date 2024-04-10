<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\ConventionnalHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\HypothecStepController;
use App\Http\Controllers\API\V1\Litigation\JurisdictionController;
use App\Http\Controllers\API\V1\Litigation\LitigationController;
use App\Http\Controllers\API\V1\Litigation\LitigationPartyController;
use App\Http\Controllers\API\V1\Litigation\LitigationResourceController;
use App\Http\Controllers\API\V1\Litigation\NatureController;

/*
|--------------------------------------------------------------------------
| Litigation API Routes
|--------------------------------------------------------------------------
*/

//contentieux
Route::resource('/litigation/parties', LitigationPartyController::class);
Route::resource('/litigation/natures', NatureController::class);
Route::resource('/litigation/jurisdiction', JurisdictionController::class);
Route::resource('/litigation', LitigationController::class);
