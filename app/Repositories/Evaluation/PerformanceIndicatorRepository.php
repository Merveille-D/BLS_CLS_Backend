<?php

namespace App\Repositories\Evaluation;

use App\Models\Evaluation\PerformanceIndicator;
use Illuminate\Support\Facades\Auth;

class PerformanceIndicatorRepository
{
    public function __construct(private PerformanceIndicator $performance_indicator) {}

    /**
     * @param  Request  $request
     * @return PerformanceIndicator
     */
    public function store($request)
    {

        $request['created_by'] = Auth::user()->id;
        $performance_indicator = $this->performance_indicator->create($request);

        return $performance_indicator;
    }

    /**
     * @param  Request  $request
     * @return PerformanceIndicator
     */
    public function update(PerformanceIndicator $performance_indicator, $request)
    {

        $performance_indicator->update($request);

        return $performance_indicator;
    }
}
