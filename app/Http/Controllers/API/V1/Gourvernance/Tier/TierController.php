<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Tier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tier\StoreTierRequest;
use App\Http\Requests\Tier\UpdateTierRequest;
use App\Models\Gourvernance\Tier;
use App\Repositories\Tier\TierRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TierController extends Controller
{

    public function __construct(private TierRepository $tier) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tiers = Tier::all();
            return api_response(true, "Liste des tiers", $tiers, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la récupération des tiers", $e->errors(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTierRequest $request)
    {
        try {
            $tier = $this->tier->store($request->all());
            return api_response(true, "Succès de l'enregistrement du tier", $tier, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tier $tier)
    {
        try {
            return api_response(true, "Infos du tier", $tier, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTierRequest $request, Tier $tier)
    {
        try {
            $this->tier->update($tier, $request->all());

            return api_response(true, "Mis à jour du tier", $tier, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tier $tier)
    {
        try {
            $tier->delete();
            return api_response(true, "Succès de la suppression du tier", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression", $e->errors(), 422);
        }
    }
}
