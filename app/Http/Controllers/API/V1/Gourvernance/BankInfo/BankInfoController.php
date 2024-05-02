<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BankInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankInfo\StoreBankInfoRequest;
use App\Http\Requests\BankInfo\UpdateBankInfoRequest;
use App\Models\Gourvernance\BankInfo\BankInfo;
use App\Repositories\BankInfo\BankInfoRepository;
use Illuminate\Validation\ValidationException;

class BankInfoController extends Controller
{

    public function __construct(private BankInfoRepository $bank_info) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bank_infos = BankInfo::get()->first();
        return api_response(true, "Liste des infos de la banque", $bank_infos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankInfoRequest $request)
    {
        if (BankInfo::exists()) { 
            return api_response(false, "Un élément existe déjà dans la table", [], 422);
        }

        try {
            $bank_info = $this->bank_info->store($request);
            return api_response(true, "Succès de l'enregistrement des infos de la banque", $bank_info, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BankInfo $bank_info)
    {
        try {
            return api_response(true, "Infos de la banque", $bank_info, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankInfoRequest $request, BankInfo $bank_info)
    {
        try {
            $this->bank_info->update($bank_info, $request->all());
            return api_response(true, "Mis à jour des infos de la banque avec succès", $bank_info, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankInfo $bank_info)
    {
        try {
            $bank_info->delete();
            return api_response(true, "Succès de la suppression des infos de la banque", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression", $e->errors(), 422);
        }
    }
}
