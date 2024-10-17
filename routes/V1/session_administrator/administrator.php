<?php

use App\Http\Controllers\API\V1\Bank\BankController;
use App\Http\Controllers\API\V1\Gourvernance\BankInfo\BankInfoController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\Mandate\MandateController;
use App\Http\Controllers\API\V1\Gourvernance\Representant\RepresentantController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ActionTransferController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ShareholderController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\CapitalController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\TaskActionTransferController;
use App\Http\Controllers\API\V1\Gourvernance\Tier\TierController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
    Route::resource('/ca_administrators', AdministratorController::class);
    Route::post('renew_mandate_administrator', [AdministratorController::class, 'renewMandate'] );

});