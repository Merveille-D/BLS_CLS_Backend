<?php

namespace App\Http\Controllers\API\V1\ContractTypeCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTypeCategory\StoreContractTypeCategoryRequest;
use App\Http\Requests\ContractTypeCategory\UpdateContractTypeCategoryRequest;
use App\Models\Contract\ContractTypeCategory;
use App\Repositories\Contract\ContractTypeCategoryRepository;
use Illuminate\Validation\ValidationException;

class ContractTypeCategoryController extends Controller
{

    public function __construct(private ContractTypeCategoryRepository $contractTypeCategory) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contractCategories = ContractTypeCategory::all();
        return api_response(true, "Liste des donnée de la catégorie", $contractCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractTypeCategoryRequest $request)
    {
        try {
            $contractTypeCategory = $this->contractTypeCategory->store($request->validated());
            return api_response(true, "Succès de l'enregistrement de la catégorie", $contractTypeCategory, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractTypeCategory $contractTypeCategory)
    {
        try {
            return api_response(true, "Infos de la catégorie", $contractTypeCategory, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractTypeCategoryRequest $request, ContractTypeCategory $contractTypeCategory)
    {
        try {
            $this->contractTypeCategory->update($contractTypeCategory, $request->all());
            return api_response(true, "Mis à jour de la catégorie avec succès", $contractTypeCategory, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractTypeCategory $contractTypeCategory)
    {
        try {
            $contractTypeCategory->delete();
            return api_response(true, "Succès de la suppression de la catégorie", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de la catégorie", $e->errors(), 422);
        }
    }
}
