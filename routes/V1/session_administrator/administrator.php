<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
    Route::resource('/ca_administrators', AdministratorController::class);
    Route::post('renew_mandate_administrator', [AdministratorController::class, 'renewMandate'] );

    Route::put('toggle_executive_ca_committee/{id}', [AdministratorController::class, 'toggleExecutiveCommittee'] );


});