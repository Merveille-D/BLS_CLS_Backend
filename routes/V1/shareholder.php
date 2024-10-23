<?php

use App\Http\Controllers\API\V1\Gourvernance\Shareholder\ShareholderController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::resource('shareholders', ShareholderController::class);
    Route::get('generate_pdf_certificat_shareholder', [ShareholderController::class, 'generatePdfCertificatShareholder'] );
});



Bonjour babe 🫠. Tu m'as manqué depuis la dernière fois. On  🥲




