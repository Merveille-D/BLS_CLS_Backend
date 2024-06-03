<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Representant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Representant\StoreRepresentantRequest;
use App\Http\Requests\Representant\UpdateRepresentantRequest;
use App\Models\Gourvernance\Representant;
use App\Repositories\Representant\RepresentantRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RepresentantController extends Controller
{

    public function __construct(private RepresentantRepository $representant) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepresentantRequest $request)
    {
        try {
            $representant = $this->representant->store($request->all());
            return api_response(true, "Succès de l'enregistrement du representant", $representant, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Representant $representant)
    {
        try {
            return api_response(true, "Infos du representant", $representant, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepresentantRequest $request, Representant $representant)
    {
        try {
            $this->representant->update($representant, $request->all());

            return api_response(true, "Mis à jour du representant", $representant, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Representant $representant)
    {
        try {
            $representant->delete();
            return api_response(true, "Succès de la suppression du representant", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression", $e->errors(), 422);
        }
    }
}
