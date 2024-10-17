<?php

use App\Http\Controllers\API\V1\Gourvernance\Mandate\MandateController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('mandates', MandateController::class);

});








