<?php

use App\Http\Controllers\API\V1\Contract\ContractController;
use App\Http\Controllers\API\V1\Contract\ContractModelCategoryController;
use App\Http\Controllers\API\V1\Contract\ContractModelController;
use App\Http\Controllers\API\V1\Contract\PartController;
use App\Http\Controllers\API\V1\Contract\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('parts', PartController::class);

});








