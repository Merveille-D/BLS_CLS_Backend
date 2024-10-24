<?php

use App\Http\Controllers\API\V1\Audit\AuditNotationController;
use App\Http\Controllers\API\V1\Audit\AuditPerformanceIndicatorController;
use App\Http\Controllers\API\V1\Audit\AuditPeriodController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('audit_notations', AuditNotationController::class);
    Route::resource('audit_periods', AuditPeriodController::class);
    Route::get('generate_pdf_fiche_suivi_audit', [AuditNotationController::class, 'generatePdfFicheSuivi']);
    Route::resource('audit_performance_indicators', AuditPerformanceIndicatorController::class);
    Route::resource('audit_performance_indicators', AuditPerformanceIndicatorController::class);
    Route::post('audit_create_transfers', [AuditNotationController::class, 'createTransfer']);

});
