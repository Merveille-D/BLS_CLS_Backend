<?php

use App\Http\Controllers\API\V1\Contract\ContractController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('contracts', ContractController::class);
    Route::get('generate_pdf_fiche_suivi_contract', [ContractController::class, 'generatePdfFicheSuivi']);
});
