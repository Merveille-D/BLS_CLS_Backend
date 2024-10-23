<?php

use App\Http\Controllers\API\V1\Contract\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('tasks', TaskController::class);
    Route::delete('delete_array_task_contracts', [TaskController::class, 'deleteArrayTaskContract'] );
    Route::put('update_status_task_contracts', [TaskController::class, 'updateStatusTaskContract'] );

});








