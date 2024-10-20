<?php

use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommitteeController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('management_committees', ManagementCommitteeController::class);
    Route::post('cd_attachements', [ManagementCommitteeController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_codir', [ManagementCommitteeController::class, 'generatePdfFicheSuivi'] );
 
});








