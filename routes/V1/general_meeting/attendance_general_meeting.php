<?php

use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\AttendanceListGeneralMeetingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('list_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'list'] );
    Route::post('update_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'updateStatus'] );
    Route::get('generate_pdf_attendance_general_meetings', [AttendanceListGeneralMeetingController::class, 'generatePdf'] );
});