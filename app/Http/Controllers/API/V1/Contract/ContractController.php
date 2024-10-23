<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\GeneratePdfContractRequest;
use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\StoreTransferContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Http\Requests\Transfer\AddTransferRequest;
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
        $contracts = Contract::query()
        ->when(request('filter') === 'recover_without_guarantee', function ($query) {
            $query->whereNotNull('date_signature');
        })
        ->get()->map(function ($contract) {

            $contract->first_part = $contract->first_part;
            $contract->second_part = $contract->second_part;
            $contract->category = $contract->contractCategory;
            $contract->type_category = $contract->contractTypeCategory;
            $contract->sub_type_category = $contract->contractSubTypeCategory;

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
            $data['first_part'] = $contract->first_part;
            $data['second_part'] = $contract->second_part;
            $data['category'] = $contract->contractCategory;
            $data['type_category'] = $contract->contractTypeCategory;
            $data['sub_type_category'] = $contract->contractSubTypeCategory;

            $data['documents'] = $contract->documents;

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
            $data['first_part'] = $contract->first_part;
            $data['second_part'] = $contract->second_part;
            $data['category'] = $contract->contractCategory;
            $data['type_category'] = $contract->contractTypeCategory;
            $data['sub_type_category'] = $contract->contractSubTypeCategory;
            $data['documents'] = $contract->documents;
            $data['transfers'] = $contract->transfers->map(function ($transfer) {
                $transfer->sender = $transfer->sender;
                $transfer->collaborators = $transfer->collaborators;
                return $transfer;
            });

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
            $data['first_part'] = $contract->first_part;
            $data['second_part'] = $contract->second_part;
            $data['category'] = $contract->contractCategory;
            $data['type_category'] = $contract->contractTypeCategory;
            $data['sub_type_category'] = $contract->contractSubTypeCategory;
            $data['documents'] = $contract->documents;

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

    public function generatePdfFicheSuivi(GeneratePdfContractRequest $request) {
        try {

            $data = $this->contract->generatePdf($request->all());
            return $data;
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
