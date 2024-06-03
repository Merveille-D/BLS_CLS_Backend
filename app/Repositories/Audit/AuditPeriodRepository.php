<?php
namespace App\Repositories\Audit;

use App\Models\Audit\AuditPeriod;
use Illuminate\Support\Facades\Auth;

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

        $request['created_by'] = Auth::user()->id;
        $audit_period = $this->audit_period->create($request);
        return $audit_period;
    }

    /**
     * @param Request $request
     *
     * @return  AuditPeriod
     */
    public function update(AuditPeriod $audit_period, $request) {

        if($request->status == true) {
            $request['completed_by'] = Auth::user()->id;
        }
        $audit_period->update($request);
        return $audit_period;
    }


}
