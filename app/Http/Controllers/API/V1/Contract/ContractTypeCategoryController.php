<?php

namespace App\Http\Controllers\API\V1\ContractTypeCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTypeCategory\ListContractTypeCategoryRequest;
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
    public function index(ListContractTypeCategoryRequest $request)
    {
        $contractTypeCategories = $this->contractTypeCategory->list($request->validated());
        return api_response(true, "Liste des donnée du type de catégorie", $contractTypeCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractTypeCategoryRequest $request)
    {
        try {
            $contractTypeCategory = $this->contractTypeCategory->store($request->validated());
            return api_response(true, "Succès de l'enregistrement du type de catégorie", $contractTypeCategory, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement du type de catégorie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractTypeCategory $contractTypeCategory)
    {
        try {
            return api_response(true, "Infos du type de catégorie", $contractTypeCategory, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du type de catégorie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractTypeCategoryRequest $request, ContractTypeCategory $contractTypeCategory)
    {
        try {
            $this->contractTypeCategory->update($contractTypeCategory, $request->all());
            return api_response(true, "Mis à jour du type de catégorie avec succès", $contractTypeCategory, 200);
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
            return api_response(true, "Succès de la suppression du type de catégorie", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression du type de catégorie", $e->errors(), 422);
        }
    }
}
