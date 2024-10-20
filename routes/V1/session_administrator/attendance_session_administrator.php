<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\AttendanceListSessionAdministratorController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('list_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'list'] );
    Route::post('update_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_session_administrators', [AttendanceListSessionAdministratorController::class, 'generatePdf'] );

});