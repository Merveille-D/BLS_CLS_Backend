<?php

namespace App\Http\Controllers\API\V1\Audit;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditNotation\CheckFoldersAuditNotationRequest;
use App\Http\Requests\AuditNotation\ListAuditNotationRequest;
use App\Http\Requests\AuditNotation\StoreTransferAuditNotationRequest;
use App\Http\Requests\AuditNotation\StoreUpdateAuditNotationRequest;
use App\Http\Requests\Transfer\AddTransferRequest;
use App\Models\Audit\AuditNotation;
use App\Repositories\Audit\AuditNotationRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuditNotationController extends Controller
{
    public function __construct(private AuditNotationRepository $audit_notation) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audit_notations = Notation::all()->map(function ($audit_notation) {
            return $this->audit_notation->auditNotationRessource($audit_notation);
        });
        return api_response(true, "Liste des evaluations", $audit_notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_notation->store($request->all());
            $audit_notation = $this->audit_notation->auditNotationRessource($audit_notation);
            return api_response(true, "Succès de l'enregistrement de l'evaluation", $audit_notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'evaluation", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditNotation $audit_notation)
    {
        try {
            $data = $this->audit_notation->auditNotationRessource($audit_notation);
            return api_response(true, "Infos de l'évaluation", $data, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'évaluation", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuditNotation $audit_notation)
    {
        try {
            $audit_notation = $this->audit_notation->update($audit_notation, $request->all());
            $audit_notation = $this->audit_notation->auditNotationRessource($audit_notation);

            return api_response(true, "Succès de la mise à jour de l'evaluation", $audit_notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la mise à jour de l'evaluation", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditNotation $audit_notation)
    {
        try {
            // $this->audit_notation->delete($audit_notation);
            return api_response(true, "Evaluation supprimé avec succès", $audit_notation, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la suppression", $e->errors(), 422);
        }
    }

    public function createTransfer(StoreTransferAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_audit_notation->createTransfer($request->all());

            return api_response(true, "Transfert de la tache avec succès", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la création du transfert", $e->errors(), 422);
        }
    }

    public function getFoldersAuditNotation(CheckFoldersAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_audit_notation->getFoldersAuditNotation($request->all());

            return api_response(true, "Dossiers disponible", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la création du transfert", $e->errors(), 422);
        }
    }
}
