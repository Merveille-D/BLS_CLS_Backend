<?php

use App\Http\Controllers\API\V1\Contract\ContractModelCategoryController;
use App\Http\Controllers\API\V1\Contract\ContractModelController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contract_models', ContractModelController::class);
    Route::resource('contract_model_categories', ContractModelCategoryController::class);

});








