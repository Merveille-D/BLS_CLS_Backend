<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notation\StoreNotationRequest;
use App\Http\Requests\Notation\StoreTransferNotationRequest;
use App\Http\Requests\Notation\UpdateNotationRequest;
use App\Models\Evaluation\Notation;
use App\Repositories\Evaluation\NotationRepository;
use Illuminate\Validation\ValidationException;

class NotationController extends Controller
{
    public function __construct(private NotationRepository $notation) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notations = Notation::whereNull('parent_id')->get()->map(function ($notation) {
            return $this->notation->notationRessource($notation);
        });
        return api_response(true, "Liste des evaluations", $notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotationRequest $request)
    {
        try {
            $notation = $this->notation->store($request->all());
            $notation = $this->notation->notationRessource($notation);
            return api_response(true, "Succès de l'enregistrement de l'evaluation", $notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'evaluation", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notation $notation)
    {
        try {
            $data = $this->notation->notationRessource($notation);
            return api_response(true, "Infos de l'évaluation", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'évaluation", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotationRequest $request, Notation $notation)
    {
        try {
            $notation = $this->notation->update($notation, $request->all());
            $notation = $this->notation->notationRessource($notation);

            return api_response(true, "Succès de la mise à jour de l'evaluation", $notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la mise à jour de l'evaluation", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notation $notation)
    {
        try {
            $this->notation->delete($notation);
            return api_response(true, "Evaluation supprimé avec succès", $notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la suppression", $e->errors(), 422);
        }
    }

    public function createTransfer(StoreTransferNotationRequest $request)
    {
        try {
            $notation = $this->notation->createTransfer($request->all());

            return api_response(true, "Transfert de la tache avec succès", $notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la création du transfert", $e->errors(), 422);
        }
    }
}
