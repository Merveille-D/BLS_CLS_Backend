<?php
namespace App\Repositories\Audit;

use App\Models\Audit\AuditPerformanceIndicator;
use Illuminate\Support\Facades\Auth;

class AuditPerformanceIndicatorRepository
{
    public function __construct(private AuditPerformanceIndicator $audit_performance_indicator) {

    }

    /**
     * @param Request $request
     *
     * @return AuditPerformanceIndicator
     */
    public function store($request) {

        $request['created_by'] = Auth::user()->id;
        $audit_performance_indicator = $this->audit_performance_indicator->create($request);
        return $audit_performance_indicator;
    }

    /**
     * @param Request $request
     *
     * @return AuditPerformanceIndicator
     */
    public function update(AuditPerformanceIndicator $audit_performance_indicator, $request) {

        $audit_performance_indicator->update($request);
        return $audit_performance_indicator;
    }


}
