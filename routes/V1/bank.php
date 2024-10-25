<?php

use App\Http\Controllers\API\V1\Bank\BankController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('banks', BankController::class);

});
