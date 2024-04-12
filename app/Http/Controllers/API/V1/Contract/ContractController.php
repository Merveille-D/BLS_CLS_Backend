<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Models\Contract\Contract;
use App\Repositories\Contract\ContractRepository;
use Illuminate\Validation\ValidationException;

class ContractController extends Controller
{
    public function __construct(private ContractRepository $contract) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::get()->map(function ($contract) {
            $contract->parts = $contract->parts;
            return $contract;
        });

        return api_response(true, "Liste des contrats", $contracts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        try {
            $contract = $this->contract->store($request);

            $data = $contract->toArray();
            $data['parts'] = $contract->parts;

            return api_response(true, "Succès de l'enregistrement du contrat", $data, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement du contrat", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        try {

            $data = $contract->toArray();
            $data['parts'] = $contract->parts;

            return api_response(true, "Information du contrat", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du contrat", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        try {
            $this->contract->update($contract, $request->all());

            $data = $contract->toArray();
            $data['parts'] = $contract->parts;

            return api_response(true, "Mis à jour du contrat avec succès", $data, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour du contrat", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try {
            $contract->delete();
            return api_response(true, "Suppression du contrat avec succès", null, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la suppression du contrat", $e->errors(), 422);
        }
    }

    public function getCategories()
    {
        return api_response(true, "Liste des catégories de contrats", Contract::CATEGORIES_VALUES, 200);
    }

    public function getTypeCategories() {
        return api_response(true, "Liste des type de categories", Contract::TYPE_CATEGORIES_VALUES, 200);
    }
}
