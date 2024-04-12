<?php

use App\Http\Controllers\API\V1\Bank\BankController;
use App\Http\Controllers\API\V1\Contract\ContractController;
use App\Http\Controllers\API\V1\Contract\PartController;
use App\Http\Controllers\API\V1\Contract\TaskController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\AdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\SessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\TaskSessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\AttendanceListGeneralMeetingController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\GeneralMeetingController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\TaskGeneralMeetingController;
use App\Http\Controllers\API\V1\Incident\AuthorIncidentController;
use App\Http\Controllers\API\V1\Incident\IncidentController;
use App\Http\Controllers\API\V1\Incident\TaskIncidentController;
use Illuminate\Http\Request;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('general_meetings', GeneralMeetingController::class);
Route::post('ag_attachements', [GeneralMeetingController::class, 'attachment']);

Route::resource('task_general_meetings', TaskGeneralMeetingController::class);
Route::delete('delete_array_task_general_meetings', [TaskGeneralMeetingController::class, 'deleteArrayTaskGeneralMeeting'] );
Route::put('update_status_task_general_meetings', [TaskGeneralMeetingController::class, 'updateStatusTaskGeneralMeeting'] );

// Route::resource('attendance_list_general_meetings', AttendanceListGeneralMeetingController::class);

Route::get('/ca_administrators/settings', [AdministratorController::class, 'settings']);
Route::resource('/ca_administrators', AdministratorController::class);

Route::resource('session_administrators', SessionAdministratorController::class);
Route::post('ca_attachements', [SessionAdministratorController::class, 'attachment']);

Route::resource('task_session_administrators', TaskSessionAdministratorController::class);
Route::delete('delete_array_task_session_administrators', [TaskSessionAdministratorController::class, 'deleteArrayTaskSessionAdministrator'] );
Route::put('update_status_task_session_administrators', [TaskSessionAdministratorController::class, 'updateStatusTaskSessionAdministrator'] );


// Banque de textes
Route::resource('banks', BankController::class);

// Contrats
Route::resource('contracts', ContractController::class);
Route::resource('parts', PartController::class);

Route::resource('tasks', TaskController::class);
Route::delete('delete_array_task_contracts', [TaskController::class, 'deleteArrayTaskContract'] );
Route::put('update_status_task_contracts', [TaskController::class, 'updateStatusTaskContract'] );


// Incidents

Route::resource('incidents', IncidentController::class);
Route::resource('author_incidents', AuthorIncidentController::class);
Route::resource('task_incidents', TaskIncidentController::class);
Route::get('get_current_task_incidents', [TaskIncidentController::class, 'getCurrentTaskIncident'] );


