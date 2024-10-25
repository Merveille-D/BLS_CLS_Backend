<?php

use App\Http\Controllers\API\V1\Gourvernance\Committee\CommitteeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('committees', CommitteeController::class);

    Route::get('list_executives_committee/{id}', [CommitteeController::class, 'listExecutives']);

});
