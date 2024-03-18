<?php

use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\CaAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Administrators\CaProcedureController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\SessionActionController;
use App\Http\Controllers\API\V1\Gourvernance\BordDirectors\Sessions\SessionAdministratorController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\AgActionController;
use App\Http\Controllers\API\V1\Gourvernance\GeneralMeeting\GeneralMeetingController;
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

// --- General Meeting --- //

Route::resource('general_meetings', GeneralMeetingController::class);

Route::post('save_shareholders_by_ag', [GeneralMeetingController::class, 'saveShareholdersByAg']);
Route::get('get_shareholders_by_ag', [GeneralMeetingController::class, 'getShareholdersByAg']);
Route::post('save_archive_files_ag', [GeneralMeetingController::class, 'saveArchiveFileAg']);

Route::resource('ag_actions', AgActionController::class);

Route::get('list_ag_steps', [AgActionController::class, 'getAgTypes']);
Route::post('update_action_ag', [AgActionController::class, 'updateAction']);



// Administrateurs
Route::resource('ca_administrators', CaAdministratorController::class);
Route::get('get_ca_type_documents', [CaProcedureController::class, 'getCaTypeDocument']);

Route::resource('ca_procedures', CaProcedureController::class);

// --- Session Administrateurs --- //

Route::resource('session_administrators', SessionAdministratorController::class);

Route::post('save_administrators_by_ca', [SessionAdministratorController::class, 'saveAdministratorsByCa']);
Route::get('get_administrators_by_ca', [SessionAdministratorController::class, 'getAdministratorsByCa']);
Route::post('save_archive_files_ca', [SessionAdministratorController::class, 'saveArchiveFileCa']);

Route::resource('ca_actions', SessionActionController::class);

Route::get('list_ca_steps', [SessionActionController::class, 'getSessionTypes']);
Route::post('update_action_ca', [SessionActionController::class, 'updateAction']);
