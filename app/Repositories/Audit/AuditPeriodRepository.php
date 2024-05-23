<?php
namespace App\Repositories\Audit;

use App\Models\Audit\AuditPeriod;

class AuditPeriodRepository
{
    public function __construct(private AuditPeriod $audit_period) {

    }

    /**
     * @param Request $request
     *
     * @return  AuditPeriod
     */
    public function store($request) {

        $audit_period = $this->audit_period->create($request->all());
        return $audit_period;
    }

    /**
     * @param Request $request
     *
     * @return  AuditPeriod
     */
    public function update(AuditPeriod $audit_period, $request) {

        $audit_period->update($request);
        return $audit_period;
    }


}
