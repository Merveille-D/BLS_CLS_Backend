<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Litigation\JurisdictionController;
use App\Http\Controllers\API\V1\Litigation\LitigationController;
use App\Http\Controllers\API\V1\Litigation\LitigationPartyController;
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
Route::post('/litigation/modify/{id}',  [LitigationController::class, 'updateLitigation']);
Route::put('/litigation/assign-user/{id}',  [LitigationController::class, 'assignUser']);
Route::put('/litigation/update-estimated-amount/{id}',  [LitigationController::class, 'updateEstimatedAmount']);
Route::put('/litigation/update-added-amount/{id}',  [LitigationController::class, 'updateAddedAmount']);
Route::put('/litigation/update-remaining-amount/{id}',  [LitigationController::class, 'updateRemainingAmount']);
Route::resource('/litigation', LitigationController::class);
