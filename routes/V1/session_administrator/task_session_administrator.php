<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\TaskSessionAdministratorController;

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

    Route::resource('task_session_administrators', TaskSessionAdministratorController::class);
    Route::delete('delete_array_task_session_administrators', [TaskSessionAdministratorController::class, 'deleteArrayTaskSessionAdministrator'] );
    Route::put('update_status_task_session_administrators', [TaskSessionAdministratorController::class, 'updateStatusTaskSessionAdministrator'] );
    Route::get('generate_pdf_checklist_and_procedures_ca', [TaskSessionAdministratorController::class, 'generatePdfTasks'] );

});








