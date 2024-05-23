<?php

namespace App\Http\Controllers\API\V1\Audit;

use App\Http\Controllers\Controller;
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
        $audit_notations = $this->audit_notation->all();
        return api_response(true, "Audit du dossier", $audit_notations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_notation->store($request->all());

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

            $hiddenAttributes = [
                'indicators', 'id', 'status', 'note', 'observation', 'date',
                'created_by', 'parent_id', 'observations', 'created_at', 'updated_at'
            ];
            $audit_notation->makeHidden($hiddenAttributes);
            $data = $audit_notation->toArray();
            $data['title'] = $audit_notation->title;

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditNotation $audit_notation)
    {
        //
    }

    public function createTransfer(StoreTransferAuditNotationRequest $request)
    {
        try {
            $audit_notation = $this->audit_notation->createTransfer($request->all());

            return api_response(true, "Transfert de la tache avec succès", $audit_notation, 200);
        } catch (ValidationException $e) {
            return api_response(false, "Echec de la création du transfert", $e->errors(), 422);
        }
    }
}
