<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Litigation\JurisdictionController;
use App\Http\Controllers\API\V1\Litigation\LitigationController;
use App\Http\Controllers\API\V1\Litigation\LitigationLawyerController;
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
Route::resource('/litigation/lawyers', LitigationLawyerController::class);
Route::resource('/litigation/jurisdiction', JurisdictionController::class);
Route::post('/litigation/modify/{id}',  [LitigationController::class, 'updateLitigation']);
Route::put('/litigation/assign-user/{id}',  [LitigationController::class, 'assignUser']);
Route::put('/litigation/update-amount/{id}',  [LitigationController::class, 'updateAmount']);
Route::put('/litigation/archive/{id}',  [LitigationController::class, 'archive']);
// Route::put('/litigation/update-added-amount/{id}',  [LitigationController::class, 'updateAddedAmount']);
// Route::put('/litigation/update-remaining-amount/{id}',  [LitigationController::class, 'updateRemainingAmount']);
Route::resource('/litigation', LitigationController::class);
