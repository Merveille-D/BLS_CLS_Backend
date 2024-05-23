<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractModelCategory\StoreContractModelCategoryRequest;
use App\Http\Requests\ContractModelCategory\UpdateContractModelCategoryRequest;
use App\Models\Contract\ContractModelCategory;
use App\Repositories\Contract\ContractModelCategoryRepository;
use Illuminate\Validation\ValidationException;

class ContractModelCategoryController extends Controller
{

    public function __construct(private ContractModelCategoryRepository $contract_model_category) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contract_model_categories = ContractModelCategory::all();
        return api_response(true, "Liste des catégories de contrats", $contract_model_categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractModelCategoryRequest $request)
    {
        try {
            $contract_model_category = $this->contract_model_category->store($request);
            return api_response(true, "Succès de l'enregistrement de la catégorie", $contract_model_category, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractModelCategory $contract_model_category)
    {
        try {
            return api_response(true, "Infos de la catégorie", $contract_model_category, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractModelCategoryRequest $request, ContractModelCategory $contract_model_category)
    {
        try {

            $this->contract_model_category->update($contract_model_category, $request->all());
            return api_response(true, "Mis à jour de la catégorie avec succès", $contract_model_category, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractModelCategory $contract_model_category)
    {
        try {
            $contract_model_category->delete();
            return api_response(true, "Succès de la suppression de la catégorie", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de la catégorie", $e->errors(), 422);
        }
    }
}
