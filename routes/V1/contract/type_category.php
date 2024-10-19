<?php

use App\Http\Controllers\API\V1\ContractTypeCategory\ContractTypeCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contract_type_categories', ContractTypeCategoryController::class);

});








