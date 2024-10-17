<?php

use App\Http\Controllers\API\V1\Incident\AuthorIncidentController;
use App\Http\Controllers\API\V1\Incident\IncidentController;
use App\Http\Controllers\API\V1\Incident\TaskIncidentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('incidents', IncidentController::class);
    Route::get('generate_pdf_fiche_suivi_incident', [IncidentController::class, 'generatePdfFicheSuivi'] );
    Route::resource('author_incidents', AuthorIncidentController::class);
    Route::resource('task_incidents', TaskIncidentController::class);
    Route::get('get_current_task_incidents', [TaskIncidentController::class, 'getCurrentTaskIncident'] );
    Route::post('complete_task_incidents', [TaskIncidentController::class, 'completeTaskIncident'] );
});








