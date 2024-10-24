<?php

namespace Database\Seeders\Guarantee;

use App\Concerns\Traits\Guarantee\CollateralDefaultSteps;
use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
use App\Concerns\Traits\Guarantee\MortgageDefaultStepTrait;
use App\Concerns\Traits\Guarantee\PersonalDefaultSteps;
use App\Models\Guarantee\GuaranteeStep;
use Illuminate\Database\Seeder;

class GuaranteeSeeder extends Seeder
{
    use CollateralDefaultSteps, DefaultGuaranteeTaskTrait, MortgageDefaultStepTrait;
    use PersonalDefaultSteps;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->savePersonalSecuritiesSteps();

        $phases = $this->defaultStockSteps();

        foreach ($phases as $key => $phase) {

            if ($key == 'formalization') {
                foreach ($phase as $key2 => $steps) {
                    // $this->line($key);
                    $formalization_type = $key2;
                    foreach ($steps as $key3 => $step) {
                        $step['formalization_type'] = $formalization_type;
                        $step['guarantee_type'] = 'stock';
                        $step['step_type'] = $key;
                        $this->createStep($step);
                    }
                }
            }
        }

        $phases = $this->defaultVehicleSteps();

        foreach ($phases as $key => $phase) {
            foreach ($phase as $step) {
                // $step['formalization_type'] = $formalization_type;
                $step['guarantee_type'] = 'vehicle';
                $step['step_type'] = $key;
                $this->createStep($step);
            }
        }

        $this->saveMortgageSteps();

        //save collateral steps (nantissement)
        $this->saveCollateral();

    }

    private function createStep($data, $parentId = null)
    {
        //remove options from data before create
        $creating = $data;
        if (isset($creating['options'])) {
            unset($creating['options']);
        }

        $step = GuaranteeStep::create(array_merge($creating, ['parent_id' => $parentId, 'rank' => $data['rank'] ?? 0]));

        if (isset($data['options'])) {
            foreach ($data['options'] as $option => $subSteps) {
                $parent_response = null;
                if (in_array($option, ['yes', 'no'])) {
                    $parent_response = $option;
                }
                foreach ($subSteps as $subStep) {
                    $subStep['formalization_type'] = $step->formalization_type;
                    $subStep['guarantee_type'] = $step->guarantee_type;
                    $subStep['step_type'] = $step->step_type;
                    $subStep['parent_response'] = $parent_response;
                    // dd($subStep);
                    $this->createStep($subStep, $step->id);
                }
            }
        }
    }
}
