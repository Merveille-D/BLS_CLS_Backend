<?php

namespace App\Http\Controllers\API\V1\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notation\CheckCollaboratorsNotationRequest;
use App\Http\Requests\Notation\ListNotationRequest;
use App\Http\Requests\Notation\StoreTransferNotationRequest;
use App\Http\Requests\Notation\StoreUpdateNotationRequest;
use App\Http\Requests\Transfer\AddTransferRequest;
use App\Models\Evaluation\Notation;
use App\Repositories\Evaluation\NotationRepository;
use Illuminate\Http\Request;
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
        $notations = $this->notation->all();
        return api_response(true, "Evaluation du collaborateur", $notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateNotationRequest $request)
    {
        try {

            $notation = $this->notation->store($request->all());
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
            $hiddenAttributes = [
                'indicators', 'status', 'note', 'observation', 'date',
                'created_by', 'parent_id', 'created_at', 'updated_at'
            ];
            $notation->makeHidden($hiddenAttributes);
            $data = $notation->toArray();
            $data['collaborator'] = $notation->collaborator;

            return api_response(true, "Infos de l'évaluation", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'évaluation", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notation $notation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notation $notation)
    {
        //
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


    public function getCollaborationNotation(CheckCollaboratorsNotationRequest $request)
    {
        try {
            $notation = $this->notation->getCollaborationNotation($request->all());

            return api_response(true, "Collaborateurs disponible", $notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la création du transfert", $e->errors(), 422);
        }
    }
}
