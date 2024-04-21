<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Recovery\RecoveryController;

/*
|--------------------------------------------------------------------------
| Recovery API Routes
|--------------------------------------------------------------------------
*/


Route::get('/recovery/tasks/{id}',  [RecoveryController::class, 'showSteps']);
Route::post('/recovery/tasks/{id}',  [RecoveryController::class, 'addTask']);
Route::put('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'updateTask']);
Route::put('/recovery/tasks/complete/{id}/{step_id}',  [RecoveryController::class, 'completeTask']);
Route::delete('/recovery/tasks/delete/{id}/{step_id}',  [RecoveryController::class, 'deleteTask']);
Route::get('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'showOneStep']);
// Route::post('/recovery/tasks/{id}/{step_id}',  [RecoveryController::class, 'updateProcess']);
Route::post('/recovery/update/{recovery}', array(RecoveryController::class, 'updateProcess'));
Route::post('/recovery/realization/{id}', array(RecoveryController::class, 'realization'));
Route::resource('/recovery', RecoveryController::class);
