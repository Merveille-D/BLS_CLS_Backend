<?php

namespace App\Http\Controllers\API\V1\Audit;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditPeriod\StoreAuditPeriodRequest;
use App\Http\Requests\AuditPeriod\UpdateAuditPeriodRequest;
use App\Models\Audit\AuditPeriod;
use App\Repositories\Audit\AuditPeriodRepository;
use Illuminate\Validation\ValidationException;

class AuditPeriodController extends Controller
{

    public function __construct(private AuditPeriodRepository $audit_period) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audit_periods = AuditPeriod::all();
        return api_response(true, "Liste des périodes d'audit", $audit_periods, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditPeriodRequest $request)
    {
        try {
            $audit_period = $this->audit_period->store($request->all());
            return api_response(true, "Succès de l'enregistrement de la période", $audit_period, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditPeriod $audit_period)
    {
        try {
            return api_response(true, "Infos de la période", $audit_period, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditPeriodRequest $request, AuditPeriod $audit_period)
    {
        try {
            $this->audit_period->update($audit_period, $request->all());
            return api_response(true, "Mis à jour de la période d'audit avec succès", $audit_period, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditPeriod $audit_period)
    {
        try {
            $audit_period->delete();
            return api_response(true, "Succès de la suppression ", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression ", $e->errors(), 422);
        }
    }
}
