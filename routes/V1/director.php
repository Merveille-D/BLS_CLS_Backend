<?php

use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\Directors\DirectorController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('directors', DirectorController::class);
    Route::post('renew_mandate_director', [DirectorController::class, 'renewMandate'] );

});








