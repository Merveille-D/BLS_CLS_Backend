<?php

use App\Http\Controllers\API\V1\Evaluation\CollaboratorController;
use App\Http\Controllers\API\V1\Evaluation\EvaluationPeriodController;
use App\Http\Controllers\API\V1\Evaluation\NotationController;
use App\Http\Controllers\API\V1\Evaluation\PerformanceIndicatorController;
use App\Http\Controllers\API\V1\Evaluation\PositionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('notations', NotationController::class);
    Route::get('generate_pdf_fiche_suivi_evaluation', [NotationController::class, 'generatePdfFicheSuivi']);
    Route::resource('performance_indicators', PerformanceIndicatorController::class);
    Route::resource('collaborators', CollaboratorController::class);
    Route::post('evaluation_create_transfers', [NotationController::class, 'createTransfer']);
    Route::resource('positions', PositionController::class);

    Route::resource('evaluation_periods', EvaluationPeriodController::class);

});
