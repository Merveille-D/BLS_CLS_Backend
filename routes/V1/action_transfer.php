<?php

use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ActionTransferController;
use App\Http\Controllers\API\V1\Gourvernance\Shareholder\TaskActionTransferController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('action_transfers', ActionTransferController::class);
    Route::post('approved_action_transfers', [ActionTransferController::class, 'approvedActionTransfer'] );

    Route::resource('task_action_transfers', TaskActionTransferController::class);
    Route::get('get_current_task_action_transfers', [TaskActionTransferController::class, 'getCurrentTaskActionTransfer'] );
    Route::post('complete_task_action_transfers', [TaskActionTransferController::class, 'completeTaskActionTransfer'] );

});








