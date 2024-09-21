<?php
namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\Guarantee;
use App\Models\Guarantee\GuaranteeStep;

trait MortgageDefaultStepTrait
{
    public function saveMortgageSteps() : void {
        $phases = $this->getMortgageStepsNew();

        foreach ($phases as $key => $steps) {
            foreach ($steps as $key2 => $step) {
                $this->createStepMortage($step);
            }
        }

    }

    private function createStepMortage($data, $parentId = null)
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
                    $subStep['parent_response'] = $parent_response;
                    $this->createStep($subStep, $step->id);
                }
            }
        }
    }

    public function getMortgageStepsNew() : array {
        return [
            "formalization" => [
                [
                    'title' => 'Initiation of mortgage',
                    'code' => 'created',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 0,
                ],
                [
                    'title' => 'Notary referral',
                    'code' => 'notary_referral',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => null,
                    'max_delay' => 0,
                    "extra" => [
                        "form" => [
                            "title" => "Notary referral",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents (TF, ID client, IFU client, credit convention)",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Receipt of the minute to be signed by the bank',
                    'code' => 'receipt_minute_bank',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 3,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Receipt of the minute to be signed by the bank",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Return of the signed minute to the notary',
                    'code' => 'return_signed_minute',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 4,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Return of the signed minute to the notary",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Signed minute documents",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Monitoring of the signature by the client/Notary',
                    'code' => 'monitoring_signature',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 5,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Registration of the minute at ANDF',
                    'code' => 'registration_minute_andf',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 6,
                    'min_delay' => null,
                    'max_delay' => 4,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Return of the registered deed to the notary\'s office',
                    'code' => 'return_registered_deed',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 7,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Receipt of the copy by the bank',
                    'code' => 'receipt_copy_bank',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 8,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Credit disbursement under conditions',
                    'code' => 'credit_disbursement_conditions',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 9,
                    'min_delay' => null,
                    'max_delay' => 3,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Receipt of the registration certificate',
                    'code' => 'receipt_registration_certificate',
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 10,
                    'min_delay' => null,
                    'max_delay' => 15,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Completed date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],

            ],

            //realizations steps
            "realization" => [
                [
                    'title' => 'Service of payment order',
                    'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date of notification",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Payment order documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Request for registration and publication of the payment order in the land registry',
                    'code' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => 20,
                    'max_delay' => 90,
                    "extra" => [
                        "form" => [
                            "title" => "Request for registration and publication of the payment order in the land registry",
                            "fields" => [
                                [
                                    "name" => "order_is_verified",
                                    "type" => "radio",
                                    "label" => "Is the registration request made and the payment order published?",
                                    "required" => true
                                ],

                            ]
                        ]
                    ],
                    "options" => [
                        "no" => [],
                        "yes" => [
                            [
                                'title' => 'Foreclosure after registrar\'s visa on the payment order',
                                'code' => ConvHypothecState::ORDER_PAYMENT_VISA,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 3,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" => "Foreclosure after registrar\'s visa on the payment order",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date du visa",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Proceed with expropriation: file specifications',
                                'code' => ConvHypothecState::EXPROPRIATION_SPECIFICATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 4,
                                'min_delay' => null,
                                'max_delay' => 50,
                                "extra" => [
                                    "form" => [
                                        "title" => "Proceed with expropriation: file specifications",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of expropriation",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "date_sell",
                                                "type" => "date",
                                                "label" => "Enter the set sale date",
                                                "required" => true,
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Expropriation documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Proceed with expropriation: address summons to acknowledge specifications',
                                'code' => ConvHypothecState::EXPROPRIATION_SUMMATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 5,
                                'min_delay' => null,
                                'max_delay' => 8,
                                "extra" => [
                                    "form" => [
                                        "title" => "Proceed with expropriation: address summons to acknowledge specifications",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of sending the summons",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Summons addressing documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Publicity of sale',
                                'code' => ConvHypothecState::ADVERTISEMENT,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 6,
                                'min_delay' => 15,
                                'max_delay' => 30,
                                "extra" => [
                                    "form" => [
                                        "title" => "Publicity of sale",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of publication",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Publication documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Sale of the property',
                                'code' => ConvHypothecState::PROPERTY_SALE,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 7,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" =>  "Sale of the property",
                                        "fields" => [
                                            [
                                                "name" => "sell_price_estate",
                                                "type" => "number",
                                                "label" => "Sale amount",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]

                ],

            ],
        ];
    }

    function getMortgageSteps() : array {
        return [
            "formalization" => [
                [
                    'title' => 'Initiation of mortgage',
                    'code' => ConvHypothecState::CREATED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 10,
                ],
                [
                    'title' => 'Verification of property ownership',
                    'code' => ConvHypothecState::PROPERTY_VERIFIED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Verification of property ownership",
                            "fields" => [
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Property documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Drafting of mortgage agreement',
                    'code' => ConvHypothecState::AGREEMENT_SIGNED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 3,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Drafting of mortgage agreement",
                            "fields" => [
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Submit registration request to notary',
                    'code' => ConvHypothecState::REGISTER_REQUEST_FORWARDED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 4,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Submit registration request to notary",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date of transmission",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents sent to the notary",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Notary sends registration request to registrar',
                    'code' => ConvHypothecState::REGISTER_REQUESTED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 5,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Notary sends registration request to registrar",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date of sending",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Request documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Receive proof of mortgage registration from notary',
                    'code' => ConvHypothecState::REGISTER,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 6,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Receive proof of mortgage registration from notary",
                            "fields" => [
                                [
                                    "name" => "is_approved",
                                    "type" => "radio",
                                    "label" => "Is the registration approved?",
                                    "required" => true
                                ],
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Registration date",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Proof of registration",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],

            ],

            //realizations steps
            "realization" => [
                [
                    'title' => 'Service of payment order',
                    'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => "Service of payment order",
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date of notification",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Payment order documents",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Request for registration and publication of the payment order in the land registry',
                    'code' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => 20,
                    'max_delay' => 90,
                    "extra" => [
                        "form" => [
                            "title" => "Request for registration and publication of the payment order in the land registry",
                            "fields" => [
                                [
                                    "name" => "order_is_verified",
                                    "type" => "radio",
                                    "label" => "Is the registration request made and the payment order published?",
                                    "required" => true
                                ],

                            ]
                        ]
                    ],
                    "options" => [
                        "no" => [],
                        "yes" => [
                            [
                                'title' => 'Foreclosure after registrar\'s visa on the payment order',
                                'code' => ConvHypothecState::ORDER_PAYMENT_VISA,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 3,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" => "Foreclosure after registrar\'s visa on the payment order",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date du visa",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Proceed with expropriation: file specifications',
                                'code' => ConvHypothecState::EXPROPRIATION_SPECIFICATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 4,
                                'min_delay' => null,
                                'max_delay' => 50,
                                "extra" => [
                                    "form" => [
                                        "title" => "Proceed with expropriation: file specifications",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of expropriation",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "date_sell",
                                                "type" => "date",
                                                "label" => "Enter the set sale date",
                                                "required" => true,
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Expropriation documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Proceed with expropriation: address summons to acknowledge specifications',
                                'code' => ConvHypothecState::EXPROPRIATION_SUMMATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 5,
                                'min_delay' => null,
                                'max_delay' => 8,
                                "extra" => [
                                    "form" => [
                                        "title" => "Proceed with expropriation: address summons to acknowledge specifications",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of sending the summons",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Summons addressing documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Publicity of sale',
                                'code' => ConvHypothecState::ADVERTISEMENT,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 6,
                                'min_delay' => 15,
                                'max_delay' => 30,
                                "extra" => [
                                    "form" => [
                                        "title" => "Publicity of sale",
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date of publication",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Publication documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Sale of the property',
                                'code' => ConvHypothecState::PROPERTY_SALE,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 7,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" =>  "Sale of the property",
                                        "fields" => [
                                            [
                                                "name" => "sell_price_estate",
                                                "type" => "number",
                                                "label" => "Sale amount",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]

                ],

            ],

        ];
    }

}
