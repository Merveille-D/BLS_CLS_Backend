<?php

use App\Http\Controllers\API\V1\Watch\LegalWatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legal watches API Routes
|--------------------------------------------------------------------------
*/

//Veille juridique
Route::get('legal-watches/generate-pdf/{legal_watch}', [LegalWatchController::class, 'generatePdf'])->middleware('auth:sanctum');
Route::resource('legal-watches', LegalWatchController::class)->middleware('auth:sanctum');
