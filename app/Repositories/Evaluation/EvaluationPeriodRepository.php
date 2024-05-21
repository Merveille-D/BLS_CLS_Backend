<?php
namespace App\Repositories\Evaluation;

use App\Models\Evaluation\EvaluationPeriod;

class EvaluationPeriodRepository
{
    public function __construct(private EvaluationPeriod $evaluation_period) {

    }

    /**
     * @param Request $request
     *
     * @return  EvaluationPeriod
     */
    public function store($request) {

        $evaluation_period = $this->evaluation_period->create($request->all());
        return $evaluation_period;
    }

    /**
     * @param Request $request
     *
     * @return  EvaluationPeriod
     */
    public function update(EvaluationPeriod $evaluation_period, $request) {

        $evaluation_period->update($request);
        return $evaluation_period;
    }


}
