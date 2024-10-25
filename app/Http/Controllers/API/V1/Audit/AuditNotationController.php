<?php

namespace App\Http\Controllers\API\V1\Audit;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditNotation\GeneratePdfAuditNotationRequest;
use App\Http\Requests\AuditNotation\StoreAuditNotationRequest;
use App\Http\Requests\AuditNotation\StoreTransferAuditNotationRequest;
use App\Models\Audit\AuditNotation;
use App\Repositories\Audit\AuditNotationRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuditNotationController extends Controller
{
    public function __construct(private AuditNotationRepository $audit_notation) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $audit_notations = AuditNotation::whereNull('parent_id')
            ->when($request->module !== null, function ($query) use ($request) {
                $query->where('module', $request->module);
            })
            ->get()->map(function ($audit_notation) {
                return $this->audit_notation->auditNotationRessource($audit_notation);
            });

        return api_response(true, 'Liste des audits', $audit_notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_notation->store($request->all());
            $audit_notation = $this->audit_notation->auditNotationRessource($audit_notation);

            return api_response(true, "Succès de l'enregistrement de l'audit", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de l'enregistrement de l'audit", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditNotation $audit_notation)
    {
        try {
            $data = $this->audit_notation->auditNotationRessource($audit_notation);

            return api_response(true, "Infos de l'audit", $data, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la récupération des infos de l'audit", $e->errors(), 422);
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

            return api_response(true, "Succès de la mise à jour de l'audit", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la mise à jour de l'audit", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditNotation $audit_notation)
    {
        try {
            $this->audit_notation->delete($audit_notation);

            return api_response(true, 'Audit supprimé avec succès', $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la suppression', $e->errors(), 422);
        }
    }

    public function createTransfer(StoreTransferAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_notation->createTransfer($request->all());

            return api_response(true, "Transfert de l'audit avec succès", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, 'Echec de la création du transfert', $e->errors(), 422);
        }
    }

    public function generatePdfFicheSuivi(GeneratePdfAuditNotationRequest $request)
    {
        try {

            $data = $this->audit_notation->generatePdf($request);

            return $data;
        } catch (Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'opération', ['server' => $th->getMessage()]);
        }
    }
}
