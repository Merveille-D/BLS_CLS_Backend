<?php
namespace App\Repositories\Guarantee;

use App\Models\Guarantee\ConvHypothecStep;

class StepRepository
{
    public function __construct(
        private ConvHypothecStep $step_model,
    ) {}
}
