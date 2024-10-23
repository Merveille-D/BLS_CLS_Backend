<?php

use App\Http\Controllers\API\V1\Contract\PartController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('parts', PartController::class);

});








