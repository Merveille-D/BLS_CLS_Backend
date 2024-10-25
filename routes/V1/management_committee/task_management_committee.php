<?php

use App\Http\Controllers\API\V1\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommitteeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('task_management_committees', TaskManagementCommitteeController::class);
    Route::delete('delete_array_task_management_committees', [TaskManagementCommitteeController::class, 'deleteArrayTaskManagementCommittee']);
    Route::put('update_status_task_management_committees', [TaskManagementCommitteeController::class, 'updateStatusTaskManagementCommittee']);
    Route::get('generate_pdf_checklist_and_procedures_codir', [TaskManagementCommitteeController::class, 'generatePdfTasks']);

});
