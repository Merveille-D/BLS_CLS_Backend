<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Models\Contract\Contract;
use App\Repositories\ContractRepository;
use Illuminate\Http\Request;
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
        $contracts = Contract::all();
        return api_response(true, "Liste des contrats", $contracts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        try {
            $contract = $this->contract->store($request);
            return api_response(true, "Succès de l'enregistrement du contrat", $contract, 200);
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
            return api_response(true, "Information du contrat", $contract, 200);
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
            return api_response(true, "Mis à jour du contrat avec succès", $contract, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour du contrat", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
