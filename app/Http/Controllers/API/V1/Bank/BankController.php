<?php

namespace App\Http\Controllers\API\V1\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\StoreBankRequest;
use App\Models\Bank\Bank;
use App\Repositories\BankRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BankController extends Controller
{

    public function __construct(private BankRepository $bank) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::all();
        return api_response(true, "Liste des donnée de la banque de texte", $banks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        try {
            $bank = $this->bank->store($request);
            return api_response(true, "Succès de l'enregistrement dans la banque de texte", $bank, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement dans la banque de texte", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        try {
            return api_response(true, "Infos de la banque de texte", $bank, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la banque de texte", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
