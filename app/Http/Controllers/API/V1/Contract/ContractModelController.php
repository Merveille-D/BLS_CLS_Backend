<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractModel\StoreContractModelRequest;
use App\Models\Contract\ContractModel;
use App\Repositories\Contract\ContractModelRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContractModelController extends Controller
{
    public function __construct(private ContractModelRepository $contract_model) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contract_models = ContractModel::all();
            return api_response(true, 'Liste des modèles de contrat', $contract_models);
        }catch (\Exception $e) {
            return api_response(false, "Echec de la récupération", $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractModelRequest $request)
    {
        try {
            $part = $this->contract_model->store($request);
            return api_response(true, 'Modèle ajouté avec succès', $part, 201);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'ajout du modèle", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractModel $contractModel)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContractModel $contractModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractModel $contractModel)
    {
        //
    }
}
