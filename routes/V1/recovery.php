<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Recovery\RecoveryController;
use App\Http\Controllers\API\V1\Recovery\RecoveryTaskController;

/*
|--------------------------------------------------------------------------
| Recovery API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth:sanctum'], function () {



// Route::get('/recovery/tasks/{id}',  [RecoveryController::class, 'showSteps']);
// Route::post('/recovery/tasks/{id}',  [RecoveryController::class, 'addTask']);
// Route::put('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'updateTask']);
// Route::put('/recovery/tasks/complete/{id}/{step_id}',  [RecoveryController::class, 'completeTask']);
// Route::delete('/recovery/tasks/delete/{id}/{step_id}',  [RecoveryController::class, 'deleteTask']);
// Route::get('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'showOneStep']);
// Route::post('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'updateProcess']);
Route::post('/recovery/update/{recovery}', [RecoveryController::class, 'updateProcess']);
Route::put('/recovery/archive/{recovery}', [RecoveryController::class, 'archive']);

//task
Route::put('/recovery/tasks/transfer/{task_id}', [RecoveryTaskController::class, 'transfer']);
Route::post('/recovery/tasks/complete/{task}', [RecoveryTaskController::class, 'complete']);
Route::resource('/recovery/tasks', RecoveryTaskController::class);

Route::get('/recovery/guarantees', [RecoveryController::class, 'getRealizableGuarantees']);
Route::get('/recovery/generate-pdf/{recovery}', [RecoveryController::class, 'generatePdf']);

Route::post('/recovery/realization/{id}', [RecoveryController::class, 'realization']);
Route::resource('/recovery', RecoveryController::class);

});
