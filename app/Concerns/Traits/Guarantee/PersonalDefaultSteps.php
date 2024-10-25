<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\AutonomousCounterState;
use App\Enums\Guarantee\AutonomousState;
use App\Enums\Guarantee\BondState;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\GuaranteeStep;

trait PersonalDefaultSteps
{
    //save the default steps for the collateral guarantee
    public function savePersonalSecuritiesSteps()
    {
        $steps = $this->getBondSteps();

        foreach ($steps as $key2 => $step) {
            $this->createPersonalStep($step);
        }

        $steps2 = $this->getAutonomousSteps();

        foreach ($steps2 as $key2 => $step) {
            $this->createPersonalStep($step);
        }

        $steps3 = $this->getCounterAutonomousStep();

        foreach ($steps3 as $key2 => $step) {
            $this->createPersonalStep($step);
        }
    }

    public function getBondSteps(): array
    {
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
                'extra' => [
                    'form' => [
                        'title' => 'Bonding Contract Drafting',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
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
                'extra' => [
                    'form' => [
                        'title' => 'Debtor\'s Debt Status Communication to the Surety Every 7 Months',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],

            ],

            // mise en demeure
            [
                'title' => 'Formal Notice to the Principal Debtor',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::DEBTOR_FORMAL_NOTICE,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Formal Notice to the Principal Debtor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            [
                'title' => 'Debtor\'s Performance',
                'guarantee_type' => GuaranteeType::BONDING,
                'code' => BondState::EXECUTION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Debtor\'s Performance',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'is_executed',
                                'type' => 'radio',
                                'label' => 'Performance by the debtor',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
                'options' => [
                    'yes' => [
                        [
                            'title' => 'Termination of the bond',
                            'code' => 'Termination_bond',
                            'guarantee_type' => GuaranteeType::BONDING,
                            'min_delay' => null,
                            'max_delay' => 10,
                            'extra' => [
                                'form' => [
                                    'title' => 'Termination of the bond',
                                    'fields' => [
                                        [
                                            'name' => 'completed_at',
                                            'type' => 'date',
                                            'label' => 'Date',
                                            'required' => true,
                                        ],

                                    ],
                                ],
                            ],
                        ],
                    ],
                    'no' => [
                        [
                            'title' => 'Surety Notification Within a Month of Debtor\'s Formal Notice',
                            'guarantee_type' => GuaranteeType::BONDING,
                            'code' => BondState::INFORM_GUARANTOR,
                            'step_type' => 'realization',
                            'rank' => 3,
                            'min_delay' => null,
                            'max_delay' => 30,
                            'extra' => [
                                'form' => [
                                    'title' => 'Surety Notification Within a Month of Debtor\'s Formal Notice',
                                    'fields' => [
                                        [
                                            'name' => 'completed_at',
                                            'type' => 'date',
                                            'label' => 'Date',
                                            'required' => true,
                                        ],

                                    ],
                                ],
                            ],
                        ],
                        [
                            'title' => 'Formal Notice to the guarantor',
                            'guarantee_type' => GuaranteeType::BONDING,
                            'code' => BondState::GUARANTOR_FORMAL_NOTICE,
                            'step_type' => 'realization',
                            'rank' => 4,
                            'min_delay' => null,
                            'max_delay' => 10,
                            'extra' => [
                                'form' => [
                                    'title' => 'Formal Notice to the guarantor',
                                    'fields' => [
                                        [
                                            'name' => 'completed_at',
                                            'type' => 'date',
                                            'label' => 'Date',
                                            'required' => true,
                                        ],
                                        [
                                            'name' => 'documents',
                                            'type' => 'file',
                                            'label' => 'Documents',
                                            'required' => true,
                                        ],

                                    ],
                                ],
                            ],
                        ],
                        [
                            'title' => 'Payment by the deposit',
                            'guarantee_type' => GuaranteeType::BONDING,
                            'code' => 'deposit_payment',
                            'step_type' => 'realization',
                            'rank' => 5,
                            'min_delay' => null,
                            'max_delay' => 10,
                            'extra' => [
                                'form' => [
                                    'title' => 'Payment by the deposit',
                                    'fields' => [
                                        [
                                            'name' => 'completed_at',
                                            'type' => 'date',
                                            'label' => 'Date',
                                            'required' => true,
                                        ],
                                        [
                                            'name' => 'is_paid',
                                            'type' => 'radio',
                                            'label' => 'Payment by the deposit',
                                            'required' => true,
                                        ],

                                    ],
                                ],
                            ],
                        ],

                    ],

                ],
            ],

        ];
    }

    public function getAutonomousSteps()
    {
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
                'title' => 'Drafting of Autonomous Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Drafting of Autonomous Guarantee Contract',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            [
                'title' => 'Autonomous guarantee Contract Validity Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Autonomous guarantee Contract Validity Verification',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
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
                'extra' => [
                    'form' => [
                        'title' => 'Signing of the Autonomous Guarantee Contract',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'contract_type',
                                'type' => 'select',
                                'label' => 'Choose the contract duration',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],

            //realization
            [
                'title' => 'Payment Request to the guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => AutonomousState::PAYEMENT_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Payment Request to the guarantor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
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
                'extra' => [
                    'form' => [
                        'title' => 'Guarantor\'s Request Verification',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            [
                'title' => 'Payment by the guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS,
                'code' => 'guarantor_payment',
                'step_type' => 'realization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Payment by the guarantor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'is_paid',
                                'type' => 'radio',
                                'label' => 'Payment by the guarantor',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
        ];
    }

    public function getCounterAutonomousStep()
    {
        return [
            [
                'title' => 'Initiation of Counter-Guarantee',
                'code' => AutonomousState::CREATED,
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
            ],
            //attacher date et un contrat de cautionnement
            [
                'title' => 'Drafting of Counter-Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REDACTION,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Drafting of Counter-Guarantee Contract',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            [
                'title' => 'Counter-Guarantee Contract Validity Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::VERIFICATION,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Counter-Guarantee Contract Validity Verification',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            //CHOISIR LA duree du contrat : gdd ou gdi [revocable/non revokable]
            [
                'title' => 'Signing of the Autonomous Guarantee Contract',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::SIGNATURE,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Signing of the Autonomous Guarantee Contract',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'contract_type',
                                'type' => 'select',
                                'label' => 'Choose the contract duration',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
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
                'extra' => [
                    'form' => [
                        'title' => 'Payment Request to the counter-guarantor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            [
                'title' => 'Beneficiary\'s request for payment to the guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::COUNTER_GUARD_REQUEST,
                'step_type' => 'realization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Beneficiary\'s request for payment to the guarantor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'documents',
                                'type' => 'file',
                                'label' => 'Documents',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
            //radio payement, date de paiement
            [
                'title' => 'Counter-guarantor\'s Request Verification',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => AutonomousCounterState::REQUEST_VERIFICATION,
                'step_type' => 'realization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 5,
                'extra' => [
                    'form' => [
                        'title' => 'Counter-guarantor\'s Request Verification',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Payment by the counter-guarantor',
                'guarantee_type' => GuaranteeType::AUTONOMOUS_COUNTER,
                'code' => 'counter_guarantor_payment',
                'step_type' => 'realization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
                'extra' => [
                    'form' => [
                        'title' => 'Payment by the counter-guarantor',
                        'fields' => [
                            [
                                'name' => 'completed_at',
                                'type' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'name' => 'is_paid',
                                'type' => 'radio',
                                'label' => 'Payment by the counter-guarantor',
                                'required' => true,
                            ],

                        ],
                    ],
                ],
            ],
        ];
    }

    private function createPersonalStep($data, $parentId = null)
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
                    $subStep['parent_response'] = $parent_response;
                    $this->createStep($subStep, $step->id);
                }
            }
        }
    }
}
