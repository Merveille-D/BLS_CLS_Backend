<?php

use App\Http\Controllers\API\V1\Contract\ContractModelController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contract_models', ContractModelController::class);

});
