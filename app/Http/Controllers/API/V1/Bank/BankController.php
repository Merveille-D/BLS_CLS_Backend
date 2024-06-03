<?php

namespace App\Http\Controllers\API\V1\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\ListBankRequest;
use App\Http\Requests\Bank\StoreBankRequest;
use App\Http\Requests\Bank\UpdateBankRequest;
use App\Models\Bank\Bank;
use App\Repositories\Bank\BankRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BankController extends Controller
{

    public function __construct(private BankRepository $bank) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListBankRequest $request)
    {
        $banks = Bank::when(request('type') !== null, function($query) {
                $query->where('type', request('type'));
            })->get();

        return api_response(true, "Liste des donnée de la banque de texte", $banks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        try {
            $bank = $this->bank->store($request->all());
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
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        try {
            $this->bank->update($bank, $request->all());
            return api_response(true, "Mis à jour du texte avec succès", $bank, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        try {
            $bank->delete();
            return api_response(true, "Succès de la suppression de la banque de texte", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de la banque de texte", $e->errors(), 422);
        }
    }
}
