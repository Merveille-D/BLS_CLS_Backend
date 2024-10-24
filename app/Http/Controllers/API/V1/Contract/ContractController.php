<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\GeneratePdfContractRequest;
use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Http\Resources\Contract\ContractResource;
use App\Models\Contract\Contract;
use App\Repositories\Contract\ContractRepository;
use Illuminate\Validation\ValidationException;
use Throwable;

class ContractController extends Controller
{
    public function __construct(private ContractRepository $contract) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::query()
            ->when(request('filter') === 'recover_without_guarantee', function ($query) {
                $query->whereNotNull('date_signature');
            })
            ->get();

        return api_response(true, 'Liste des contrats', ContractResource::collection($contracts), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        try {
            $contract = $this->contract->store($request);

            return api_response(true, "Succès de l'enregistrement du contrat", new ContractResource($contract), 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement du contrat", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        try {
            return api_response(true, 'Information du contrat', new ContractResource($contract), 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la récupération des infos du contrat', $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        try {
            $contract = $this->contract->update($contract, $request->all());

            return api_response(true, 'Mis à jour du contrat avec succès', new ContractResource($contract), 200);
        } catch (ValidationException $e) {

            return api_response(false, 'Echec de la mise à jour du contrat', $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try {
            $contract->delete();

            return api_response(true, 'Suppression du contrat avec succès', null, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la suppression du contrat', $e->errors(), 422);
        }
    }

    public function generatePdfFicheSuivi(GeneratePdfContractRequest $request)
    {
        try {

            $data = $this->contract->generatePdf($request->all());

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
