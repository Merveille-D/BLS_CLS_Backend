<?php
namespace App\Repositories\Evaluation;

use App\Models\Evaluation\PerformanceIndicator;

class PerformanceIndicatorRepository
{
    public function __construct(private PerformanceIndicator $performance_indicator) {

    }

    /**
     * @param Request $request
     *
     * @return PerformanceIndicator
     */
    public function store($request) {

        $performance_indicator = $this->performance_indicator->create($request->all());
        return $performance_indicator;
    }

    /**
     * @param Request $request
     *
     * @return PerformanceIndicator
     */
    public function update(PerformanceIndicator $performance_indicator, $request) {

        $performance_indicator->update($request);
        return $performance_indicator;
    }


}
