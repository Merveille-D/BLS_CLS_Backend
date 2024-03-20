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

Route::post('save_attachement_meeting', [GeneralMeetingController::class, 'saveAttachmentMeeting']);
Route::get('get_ag_steps', [GeneralMeetingController::class, 'getAgStep']);

