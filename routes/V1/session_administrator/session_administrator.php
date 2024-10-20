<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\SessionAdministratorController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('session_administrators', SessionAdministratorController::class);
    Route::post('ca_attachements', [SessionAdministratorController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_ca', [SessionAdministratorController::class, 'generatePdfFicheSuivi'] );

});








