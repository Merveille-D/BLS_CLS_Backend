<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractModel\StoreContractModelRequest;
use App\Http\Requests\ContractModel\UpdateContractModelRequest;
use App\Models\Contract\ContractModel;
use App\Repositories\Contract\ContractModelRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContractModelController extends Controller
{
    public function __construct(private ContractModelRepository $contract_model) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $contract_models = $this->contract_model->list($request->all());

            return api_response(true, 'Liste des modèles de contrat', $contract_models);
        } catch (Exception $e) {
            return api_response(false, 'Echec de la récupération', $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractModelRequest $request)
    {
        try {
            $contract_model = $this->contract_model->store($request->validated());

            return api_response(true, 'Modèle ajouté avec succès', $contract_model, 201);
        } catch (ValidationException $e) {
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
    public function update(UpdateContractModelRequest $request, ContractModel $contractModel)
    {
        try {
            $contract_model = $this->contract_model->update($contractModel, $request->validated());

            return api_response(true, 'Modèle mis à jour avec succès', $contract_model, 201);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la mise à jour du modèle', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractModel $contractModel)
    {
        try {
            $contractModel->delete();

            return api_response(true, 'Succès de la suppression du modèle', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la supression du modèle', $e->errors(), 422);
        }
    }
}
