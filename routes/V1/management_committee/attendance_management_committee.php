<?php

use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommitteeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('list_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'list'] );
    Route::post('update_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_management_committees', [AttendanceListManagementCommitteeController::class, 'generatePdf'] );


});