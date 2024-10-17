<?php

use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\TaskGeneralMeetingController;

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('task_general_meetings', TaskGeneralMeetingController::class);
    Route::delete('delete_array_task_general_meetings', [TaskGeneralMeetingController::class, 'deleteArrayTaskGeneralMeeting'] );
    Route::put('update_status_task_general_meetings', [TaskGeneralMeetingController::class, 'updateStatusTaskGeneralMeeting'] );
    Route::get('generate_pdf_checklist_and_procedures_ag', [TaskGeneralMeetingController::class, 'generatePdfTasks'] );

});








