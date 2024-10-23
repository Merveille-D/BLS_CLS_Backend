<?php

namespace App\Http\Controllers\API\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractCategory\StoreContractCategoryRequest;
use App\Http\Requests\ContractCategory\UpdateContractCategoryRequest;
use App\Models\Contract\ContractCategory;
use App\Repositories\Contract\ContractCategoryRepository;
use Illuminate\Validation\ValidationException;

class ContractCategoryController extends Controller
{

    public function __construct(private ContractCategoryRepository $contractCategory) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contractCategories = ContractCategory::all();
        return api_response(true, "Liste des donnée de la catégorie", $contractCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractCategoryRequest $request)
    {
        try {
            $contractCategory = $this->contractCategory->store($request->validated());
            return api_response(true, "Succès de l'enregistrement de la catégorie", $contractCategory, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractCategory $contractCategory)
    {
        try {
            return api_response(true, "Infos de la catégorie", $contractCategory, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de la catégorie", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractCategoryRequest $request, ContractCategory $contractCategory)
    {
        try {
            $this->contractCategory->update($contractCategory, $request->all());
            return api_response(true, "Mis à jour de la catégorie avec succès", $contractCategory, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractCategory $contractCategory)
    {
        try {
            $contractCategory->delete();
            return api_response(true, "Succès de la suppression de la catégorie", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de la catégorie", $e->errors(), 422);
        }
    }
}
