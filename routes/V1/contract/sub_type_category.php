<?php

use App\Http\Controllers\API\V1\ContractSubTypeCategory\ContractSubTypeCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contract_sub_type_categories', ContractSubTypeCategoryController::class);

});








