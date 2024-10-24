<?php

namespace App\Repositories\Evaluation;

use App\Models\Evaluation\EvaluationPeriod;
use Illuminate\Support\Facades\Auth;

class EvaluationPeriodRepository
{
    public function __construct(private EvaluationPeriod $evaluation_period) {}

    /**
     * @param  Request  $request
     * @return EvaluationPeriod
     */
    public function store($request)
    {

        $request['created_by'] = Auth::user()->id;
        $evaluation_period = $this->evaluation_period->create($request);

        return $evaluation_period;
    }

    /**
     * @param  Request  $request
     * @return EvaluationPeriod
     */
    public function update(EvaluationPeriod $evaluation_period, $request)
    {

        if ($request->status == true) {
            $request['completed_by'] = Auth::user()->id;
        }

        $evaluation_period->update($request);

        return $evaluation_period;
    }
}
