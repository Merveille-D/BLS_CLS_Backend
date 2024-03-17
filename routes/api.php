<?php

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

Route::resource('general_meetings', GeneralMeetingController::class);
Route::get('save_shareholders_by_ag', [GeneralMeetingController::class, 'saveShareholdersByAg']);
Route::get('get_shareholders_by_ag', [GeneralMeetingController::class, 'getShareholdersByAg']);

Route::get('list_ag_steps', [AgActionController::class, 'getAgTypes']);

