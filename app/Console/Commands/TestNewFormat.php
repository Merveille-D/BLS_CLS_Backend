<?php

namespace App\Console\Commands;

use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
use App\Models\Guarantee\GuaranteeStep;
use Illuminate\Console\Command;

class TestNewFormat extends Command
{
    use DefaultGuaranteeTaskTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-new-format';

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
        $phases = $this->defaultStockSteps();

        foreach ($phases as $key => $phase) {

            if ($key == 'formalization') {
                foreach ($phase as $key2 => $steps) {
                    // $this->line($key);
                    $formalization_type = $key2;
                    foreach ($steps as $key3 => $step) {
                        $step['formalization_type'] = $formalization_type;
                        $step['guarantee_type'] = 'stock';
                        $step['type'] = $key;
                        $this->createStep($step);
                    }
                }
            }
        }
        $this->info('Test new format');
    }

    private function createStep($data, $parentId = null)
    {
        // dd($data);
        $step = GuaranteeStep::create(array_merge($data, ['parent_id' => $parentId, 'rank' => $data['rank'] ?? 0]));

        if (isset($data['options'])) {
            foreach ($data['options'] as $option => $subSteps) {
                foreach ($subSteps as $subStep) {
                    $subStep['formalization_type'] = $step->formalization_type;
                    $subStep['guarantee_type'] = $step->guarantee_type;
                    $subStep['type'] = $step->type;
                    $this->createStep($subStep, $step->id);
                }
            }
        }
    }
}
