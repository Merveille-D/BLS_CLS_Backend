<?php

use App\Http\Controllers\API\V1\ContractCategory\ContractCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contract_categories', ContractCategoryController::class);

});








