<?php

use App\Http\Controllers\API\V1\Transfer\TransferController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('complete_transfers', [TransferController::class, 'completeTransfer']);
});
