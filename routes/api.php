<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
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

Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
Route::resource('/ca_administrators', AdministratorController::class);
