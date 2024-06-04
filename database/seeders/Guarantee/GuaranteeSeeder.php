<?php

namespace Database\Seeders\Guarantee;

use App\Concerns\Traits\Guarantee\DefaultGuaranteeTaskTrait;
use App\Concerns\Traits\Guarantee\MortgageDefaultStepTrait;
use App\Enums\ConvHypothecState;
use App\Enums\Guarantee\AutonomousCounterState;
use App\Enums\Guarantee\AutonomousState;
use App\Enums\Guarantee\BondState;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\GuaranteeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuaranteeSeeder extends Seeder
{
    use DefaultGuaranteeTaskTrait, MortgageDefaultStepTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $steps = $this->getBondSteps();

        foreach ($steps as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

        $steps2 = $this->getAutonomousSteps();

        foreach ($steps2 as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

        $steps3 = $this->getCounterAutonomousStep();

        foreach ($steps3 as $step) {
            $exist = GuaranteeStep::where('code', $step['code'])->whereGuaranteeType($step['guarantee_type'])->first();
            if (!$exist)
                GuaranteeStep::create($step);
        }

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

        $this->saveMortgageSteps();

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


    function getBondSteps() : array {
        return [
            [
                'title' => 'Initiation of the guarantee',
                'code' => BondState::CREATED,
                'guarantee_type' => GuaranteeType::BONDING,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //attacher date et un contrat de cautionnement
            [
                'title' => 'Bonding Contract Drafting',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            // completer
            [
                'title' => 'Verification of Bonding Contract Validity (Written and Mandatory Clauses)',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            // A completer
            [
                'title' => 'Debtor\'s Solvency Verification',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //inserer date et doc de communication
            [
                'title' => 'Debtor\'s Debt Status Communication to the Surety Every 7 Months',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::COMMUNICATION,
                'step_type' => 'formalization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 180,
            ],

            //realization doc, date
            [
                'title' => 'Formal Notice to the Principal Debtor',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::DEBTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Debtor\'s Performance',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::EXECUTION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Surety Notification Within a Month of Debtor\'s Formal Notice',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::INFORM_GUARANTOR,
                'step_type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 30, // ajouter a date de mise ne demeure
            ],
            // documenjt et  date
            [
                'title' => 'Formal Notice to the guarantor',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Payment by the guarantor',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::GUARANTOR_PAYMENT,
                'step_type' => 'realization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
            ],

        ];
    }

    public function getAutonomousSteps() {
        return [
            [
                'title' => 'Initiation of the guarantee',
                'code' => AutonomousState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //attacher date et un contrat de cautionnement
            [
                'title' => 'Drafting of Counter-Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Counter-Guarantee Contract Validity Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //CHOISIR LA duree du contrat : gdd ou gdi [revocable/non revokable]
            [
                'title' => 'Signing of the Autonomous Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //realization
            //doc et date
            [
                'title' => 'Payment Request to the counter-guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //radio payement, date de paiement
            [
                'title' => 'Guarantor\'s Request Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 5,
            ],
        ];
    }

    public function getCounterAutonomousStep() {
        return [
            [
                'title' => 'Start of Counter-Guarantee',
                'code' => AutonomousCounterState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Drafting of Counter-Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Counter-Guarantee Contract Validity Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Signing of the Autonomous Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
            ],

            //realization
            [
                'title' => 'Payment Request to the counter-guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::GUARANTOR_PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Payment Request to the counter-guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::COUNTER_GUARD_REQUEST,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            [
                'title' => 'Counter-guarantor\'s Request Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
            ],

        ];
    }
}
