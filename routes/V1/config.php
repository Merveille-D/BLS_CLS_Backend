<?php

use App\Http\Controllers\API\V1\Gourvernance\BankInfo\BankInfoController;
use App\Http\Controllers\API\V1\Gourvernance\Representant\RepresentantController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\CapitalController;
use App\Http\Controllers\API\V1\Gourvernance\Tier\TierController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('representants', RepresentantController::class);
    Route::resource('tiers', TierController::class);

    Route::resource('bank_infos', BankInfoController::class);
    Route::resource('capitals', CapitalController::class);

});