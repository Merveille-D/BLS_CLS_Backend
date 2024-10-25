<?php

use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\GeneralMeetingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('general_meetings', GeneralMeetingController::class);
    Route::post('ag_attachements', [GeneralMeetingController::class, 'attachment']);
    Route::get('generate_pdf_fiche_suivi_ag', [GeneralMeetingController::class, 'generatePdfFicheSuivi']);

});
