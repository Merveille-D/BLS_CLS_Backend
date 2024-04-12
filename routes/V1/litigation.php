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
Route::resource('/litigation', LitigationController::class);
