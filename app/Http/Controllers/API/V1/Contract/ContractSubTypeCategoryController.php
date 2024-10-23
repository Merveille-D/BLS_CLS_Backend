<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractSubTypeCategory\StoreContractSubTypeCategoryRequest;
use App\Http\Requests\ContractSubTypeCategory\UpdateContractSubTypeCategoryRequest;
use App\Http\Requests\ContractSubTypeCategory\ListContractSubTypeCategoryRequest;
use App\Models\Contract\ContractSubTypeCategory;
use App\Repositories\Contract\ContractSubTypeCategoryRepository;
use Illuminate\Validation\ValidationException;

class ContractSubTypeCategoryController extends Controller
{

    public function __construct(private ContractSubTypeCategoryRepository $contractSubTypeCategory) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListContractSubTypeCategoryRequest $request)
    {
        $contractSubTypeCategories = $this->contractSubTypeCategory->list($request->validated());
        return api_response(true, "Liste des donnée du sous type de la catégorie", $contractSubTypeCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractSubTypeCategoryRequest $request)
    {
        try {
            $contractSubTypeCategory = $this->contractSubTypeCategory->store($request->validated());
            return api_response(true, "Succès de l'enregistrement du sous type de la catégorie", $contractSubTypeCategory, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement du sous type de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractSubTypeCategory $contractSubTypeCategory)
    {
        try {
            return api_response(true, "Infos du sous type de la catégorie", $contractSubTypeCategory, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos du sous type de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractSubTypeCategoryRequest $request, ContractSubTypeCategory $contractSubTypeCategory)
    {
        try {
            $this->contractSubTypeCategory->update($contractSubTypeCategory, $request->all());
            return api_response(true, "Mis à jour du sous type de la catégorie avec succès", $contractSubTypeCategory, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractSubTypeCategory $contractSubTypeCategory)
    {
        try {
            $contractSubTypeCategory->delete();
            return api_response(true, "Succès de la suppression du sous type de la catégorie", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression du sous type de la catégorie", $e->errors(), 422);
        }
    }
}
