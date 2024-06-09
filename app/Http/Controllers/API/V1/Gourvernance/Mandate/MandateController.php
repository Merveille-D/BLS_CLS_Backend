<?php

namespace App\Http\Controllers\API\V1\Gourvernance\Mandate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mandate\UpdateMandateRequest;
use App\Models\Gourvernance\Mandate;
use App\Repositories\Mandate\MandateRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MandateController extends Controller
{

    public function __construct(private MandateRepository $mandate) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mandate $mandate)
    {
        try {
            return api_response(true, "Infos du mandat", $mandate, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMandateRequest $request, Mandate $mandate)
    {
        if($mandate->mandatable->lastMandate()->id != $mandate->id) {
            return api_response(false, "Ce n'est pas le dernier mandat à modifier", null, 422);
        }

        try {
            $this->mandate->update($mandate, $request->all());

            return api_response(true, "Mis à jour du mandat", $mandate, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mandate $mandate)
    {
        //
    }
}
