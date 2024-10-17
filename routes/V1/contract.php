<?php

use App\Http\Controllers\API\V1\Contract\ContractController;
use App\Http\Controllers\API\V1\Contract\ContractModelCategoryController;
use App\Http\Controllers\API\V1\Contract\ContractModelController;
use App\Http\Controllers\API\V1\Contract\PartController;
use App\Http\Controllers\API\V1\Contract\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contracts', ContractController::class);
    Route::get('get_contract_categories', [ContractController::class, 'getCategories']);
    Route::get('get_contract_type_categories', [ContractController::class, 'getTypeCategories']);
    Route::get('generate_pdf_fiche_suivi_contract', [ContractController::class, 'generatePdfFicheSuivi'] );

    Route::resource('parts', PartController::class);

    Route::resource('contract_models', ContractModelController::class);
    Route::resource('contract_model_categories', ContractModelCategoryController::class);

    Route::resource('tasks', TaskController::class);
    Route::delete('delete_array_task_contracts', [TaskController::class, 'deleteArrayTaskContract'] );
    Route::put('update_status_task_contracts', [TaskController::class, 'updateStatusTaskContract'] );

});








