<?php

namespace App\Http\Controllers\API\V1\Audit;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditPerformanceIndicator\ListAuditPerformanceIndicatorRequest;
use App\Http\Requests\AuditPerformanceIndicator\StoreAuditPerformanceIndicatorRequest;
use App\Http\Requests\AuditPerformanceIndicator\UpdateAuditPerformanceIndicatorRequest;
use App\Models\Audit\AuditPerformanceIndicator;
use App\Repositories\Audit\AuditPerformanceIndicatorRepository;
use Illuminate\Validation\ValidationException;

class AuditPerformanceIndicatorController extends Controller
{
    public function __construct(private AuditPerformanceIndicatorRepository $auditPerformanceIndicator) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListAuditPerformanceIndicatorRequest $request)
    {
        $audit_performance_indicators = AuditPerformanceIndicator::where('module', request('module'))->get();
        return api_response(true, "Liste des indicateurs de performance", $audit_performance_indicators, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditPerformanceIndicatorRequest $request)
    {
        try {
            $auditPerformanceIndicator = $this->auditPerformanceIndicator->store($request);
            return api_response(true, "Succès de l'enregistrement de l'indicateur de performance", $auditPerformanceIndicator, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement de l'indicateur de performance", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditPerformanceIndicator $auditPerformanceIndicator)
    {
        try {
            return api_response(true, "Infos de l'indicateur de performance", $auditPerformanceIndicator, 200);
        }catch( ValidationException $e ) {
            return api_response(false, "Echec de la récupération des infos de l'indicateur de performance", $e->errors(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditPerformanceIndicatorRequest $request, AuditPerformanceIndicator $auditPerformanceIndicator)
    {
        try {
            $this->auditPerformanceIndicator->update($auditPerformanceIndicator, $request->all());
            return api_response(true, "Mis à jour de l'indicateur de performance", $auditPerformanceIndicator, 200);
        } catch (ValidationException $e) {

            return api_response(false, "Echec de la mise à jour", $e->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditPerformanceIndicator $auditPerformanceIndicator)
    {
        try {
            $auditPerformanceIndicator->delete();
            return api_response(true, "Succès de la suppression de l'indicateur de performance", null, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de la supression de l'indicateur de performance", $e->errors(), 422);
        }
    }
}
