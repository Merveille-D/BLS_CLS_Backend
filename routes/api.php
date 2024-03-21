<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\ConventionnalHypothecController;
use App\Http\Controllers\API\V1\Guarantee\ConventionnalHypothecs\HypothecStepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/conventionnal_hypotec/steps', [HypothecStepController::class, 'index']);
Route::resource('/conventionnal_hypothec', ConventionnalHypothecController::class);
Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
Route::resource('/ca_administrators', AdministratorController::class);
