<?php

namespace App\Console\Commands;

use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
use App\Concerns\Traits\Guarantee\MortgageDefaultStepTrait;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\GuaranteeStep;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSteps extends Command
{
    use DefaultGuaranteeTaskTrait, MortgageDefaultStepTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-steps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $old_steps = GuaranteeStep::whereGuaranteeType('mortgage')->delete();
        // foreach ($old_steps as $key => $old_step) {
        //     $old_step->delete();
        // }
        $this->saveMortgageSteps();

        $this->info('mortgage steps updated! ');
    }

    private function createStep($data, $parentId = null)
    {
        //remove options from data before create
        $creating = $data;
        if (isset($creating['options']))
            unset($creating['options']);


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
