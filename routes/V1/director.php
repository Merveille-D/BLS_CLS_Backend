<?php

use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\Directors\DirectorController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('directors', DirectorController::class);
    Route::put('toggle_executive_cd_committee/{id}', [DirectorController::class, 'toggleExecutiveCommittee']);

    Route::post('renew_mandate_director', [DirectorController::class, 'renewMandate']);

    Route::get('generate_pdf_list_directors', [DirectorController::class, 'generatePdf']);

});
