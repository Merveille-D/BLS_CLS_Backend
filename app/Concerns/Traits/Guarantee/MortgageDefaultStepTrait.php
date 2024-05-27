<?php
namespace App\Concerns\Traits\Guarantee;

use App\Enums\ConvHypothecState;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Guarantee\Guarantee;
use App\Models\Guarantee\GuaranteeStep;

trait MortgageDefaultStepTrait
{
    public function saveMortgageSteps() : void {
        $phases = $this->getMortgageSteps();

        foreach ($phases as $key => $steps) {
            foreach ($steps as $key2 => $step) {
                $this->createStepMortage($step);
            }
        }

    }

    private function createStepMortage($data, $parentId = null)
    {
        // dd($data);
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

    function getMortgageSteps() : array {
        return [
            "formalization" => [
                [
                    'title' => 'Initiation de l\'hypothèque',
                    'code' => ConvHypothecState::CREATED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 10,
                ],
                [
                    'title' => 'Vérifier la propriété de l\'immeuble',
                    'code' => ConvHypothecState::PROPERTY_VERIFIED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::PROPERTY_VERIFIED],
                            "fields" => [
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents de la propriété",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Rédiger la convention d\'hypothèque',
                    'code' => ConvHypothecState::AGREEMENT_SIGNED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 3,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::AGREEMENT_SIGNED],
                            "fields" => [
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents de la convention",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Transmettre une demande d\'inscription au notaire',
                    'code' => ConvHypothecState::REGISTER_REQUEST_FORWARDED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 4,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER_REQUEST_FORWARDED],
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date de la transmission",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents envoyés au notaire",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Envoi de la demande d\'inscription par le notaire au régisseur',
                    'code' => ConvHypothecState::REGISTER_REQUESTED,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 5,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER_REQUESTED],
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date d'envoi",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents de la demande",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Recevoir la preuve d\'inscription de l\'hypothèque chez le notaire',
                    'code' => ConvHypothecState::REGISTER,
                    'step_type' => 'formalization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 6,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::REGISTER],
                            "fields" => [
                                [
                                    "name" => "is_approved",
                                    "type" => "radio",
                                    "label" => "L\'inscription est elle approuvée ?",
                                    "required" => true
                                ],
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date de l'inscription",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Preuve de l'inscription",
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
                    'title' => 'Signification commendement de payer',
                    'code' => ConvHypothecState::SIGNIFICATION_REGISTERED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 1,
                    'min_delay' => null,
                    'max_delay' => 10,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::SIGNIFICATION_REGISTERED],
                            "fields" => [
                                [
                                    "name" => "completed_at",
                                    "type" => "date",
                                    "label" => "Date de la signification",
                                    "required" => true
                                ],
                                [
                                    "name" => "documents",
                                    "type" => "file",
                                    "label" => "Documents de la signification",
                                    "required" => true
                                ],

                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Demande D\'inscription et publication du commendement de payer dans  les registres de la propriété foncière',
                    'code' => ConvHypothecState::ORDER_PAYMENT_VERIFIED,
                    'step_type' => 'realization',
                    'guarantee_type' => GuaranteeType::MORTGAGE,
                    'rank' => 2,
                    'min_delay' => 20,
                    'max_delay' => 90,
                    "extra" => [
                        "form" => [
                            "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VERIFIED],
                            "fields" => [
                                [
                                    "name" => "order_is_verified",
                                    "type" => "radio",
                                    "label" => "Est-ce que la demande d\'inscription est éffectué et le commendement de payer est publié ?",
                                    "required" => true
                                ],

                            ]
                        ]
                    ],
                    "options" => [
                        "no" => [],
                        "yes" => [
                            [
                                'title' => 'Saisie immobilière après visa du régisseur sur le commendement de payer',
                                'code' => ConvHypothecState::ORDER_PAYMENT_VISA,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 3,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::ORDER_PAYMENT_VISA],
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
                                                "label" => "Documents du commendement",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Poursuivre l\'expropriation : DEPOSER CAHIER DE CHARGES',
                                'code' => ConvHypothecState::EXPROPRIATION_SPECIFICATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 4,
                                'min_delay' => null,
                                'max_delay' => 50,
                                "extra" => [
                                    "form" => [
                                        "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::EXPROPRIATION_SPECIFICATION],
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date de l'expropriation",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "date_sell",
                                                "type" => "date",
                                                "label" => "Renseigner la date de vente fixée",
                                                "required" => true,
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents de l'expropriation",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Poursuivre l\'expropriation : ADRESSER SOMMATION A PRENDRE CONNAISSANCE DU CAHIER DES CHARGES',
                                'code' => ConvHypothecState::EXPROPRIATION_SUMMATION,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 5,
                                'min_delay' => null,
                                'max_delay' => 8,
                                "extra" => [
                                    "form" => [
                                        "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::EXPROPRIATION_SUMMATION],
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date d'adressage de la sommation",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents d'adressage de la sommation",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Publicité de vente',
                                'code' => ConvHypothecState::ADVERTISEMENT,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 6,
                                'min_delay' => 15,
                                'max_delay' => 30,
                                "extra" => [
                                    "form" => [
                                        "title" => ConvHypothecState::STATES_VALUES[ConvHypothecState::ADVERTISEMENT],
                                        "fields" => [
                                            [
                                                "name" => "completed_at",
                                                "type" => "date",
                                                "label" => "Date de la publication",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Documents de la publication",
                                                "required" => true
                                            ],

                                        ]
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Vente de l\'immeuble',
                                'code' => ConvHypothecState::PROPERTY_SALE,
                                'step_type' => 'realization',
                                'guarantee_type' => GuaranteeType::MORTGAGE,
                                'rank' => 7,
                                'min_delay' => null,
                                'max_delay' => 10,
                                "extra" => [
                                    "form" => [
                                        "title" =>  ConvHypothecState::STATES_VALUES[ConvHypothecState::PROPERTY_SALE],
                                        "fields" => [
                                            [
                                                "name" => "sell_price_estate",
                                                "type" => "number",
                                                "label" => "Montant de vente",
                                                "required" => true
                                            ],
                                            [
                                                "name" => "documents",
                                                "type" => "file",
                                                "label" => "Insérer PV de la vente",
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
