<?php

use App\Http\Controllers\API\V1\Watch\LegalWatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legal watches API Routes
|--------------------------------------------------------------------------
*/

//Veille juridique
Route::resource('/legal-watches', LegalWatchController::class);
