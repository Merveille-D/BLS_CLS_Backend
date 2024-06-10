<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\GuaranteeType;

trait DefaultGuaranteeTaskTrait
{
    public function defaultStockSteps() : array {
        return [
            "formalization" => [
                "conventional" => [
                    [
                        "title" => 'Initiation of the guarantee',
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 0,
                    ],
                    [
                        "title" => 'Drafting of the guarantee agreement',
                        "code" => "redaction",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Drafting of the guarantee agreement',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of the agreement",
                                        "required" => true
                                    ],
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
                        "title" => 'Deposit of the agreement with the notary',
                        "code" => "notary_deposit",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Deposit of the agreement with the notary',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of deposit of the agreement",
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
                        "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
                        "code" => "notary_transmission",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
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
                                        "label" => "Documents",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => 'Obtaining the registered guarantee agreement',
                        "code" => "convention_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Obtaining the registered guarantee agreement',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of obtaining",
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
                        "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
                        "code" => "rccm_registration",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
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
                                        "label" => "Documents",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => 'Receipt of proof of registration of the guarantee',
                        "code" => "rccm_proof",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Receipt of proof of registration of the guarantee',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of receipt",
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
                        "title" => 'Referral to the bailiff for notifications and/or domiciliation formalities with "favorable declaration" notice',
                        "code" => "huissier_notification",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Referral to the bailiff for notifications and/or domiciliation formalities with "favorable declaration" notice',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of referral",
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
                        "title" => 'Obtaining domiciliation acts with "favorable declaration" notice',
                        "code" => "domiciliation_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Obtaining domiciliation acts with "favorable declaration" notice',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of obtaining",
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
                        "title" => 'Obtaining the pledge slip issued by the clerk to the debtor',
                        "code" => "stock_pledge_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Obtaining the pledge slip issued by the clerk to the debtor',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of obtaining",
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
                "legal" => [
                    [
                        "title" => 'Initiation of the guarantee',
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 10,
                    ],
                    [
                        "title" => 'Referral to the competent jurisdiction',
                        "code" => "referral",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Referral to the competent jurisdiction',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of referral",
                                        "required" => true
                                    ],
                                    [
                                        "name" => "documents",
                                        "type" => "file",
                                        "label" => "Documents",
                                        "required" => true
                                    ],
                                    [
                                        "name" => "is_favorable",
                                        "type" => "radio",
                                        "label" => "Is the decision favorable?",
                                        "required" => true
                                    ],
                                ]
                            ]
                        ],
                        "options" => [
                                    "yes" => [
                                        [
                                            "title" => 'Obtaining the decision authorizing the guarantee',
                                            "code" => "obtenir_decision_autorisant_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => 'Obtaining the decision authorizing the guarantee',
                                                    "fields" => [
                                                        [
                                                            "name" => "completed_at",
                                                            "type" => "date",
                                                            "label" => "Date of obtaining",
                                                            "required" => true
                                                        ],
                                                        [
                                                            "name" => "documents",
                                                            "type" => "file",
                                                            "label" => "Documents de décision",
                                                            "required" => true
                                                        ],
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
                                            "code" => "transmission_notaire_demande_inscription_garantie_rccm",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
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
                                                            "label" => "Documents de transmission",
                                                            "required" => true
                                                        ],
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
                                            "code" => "envoi_demande_notaire_rccm_enregistrement_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
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
                                                            "label" => "Documents d'envoi",
                                                            "required" => true
                                                        ],
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "title" => 'Receipt of proof of registration of the guarantee',
                                            "code" => "reception_preuve_inscription_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => 'Receipt of proof of registration of the guarantee',
                                                    "fields" => [
                                                        [
                                                            "name" => "completed_at",
                                                            "type" => "date",
                                                            "label" => "Date of receipt",
                                                            "required" => true
                                                        ],
                                                        [
                                                            "name" => "documents",
                                                            "type" => "file",
                                                            "label" => "Documents de preuve",
                                                            "required" => true
                                                        ],
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],

                                    "no" => [
                                        [
                                            "title" => 'Exercising legal remedies',
                                            "code" => "exercer_les_voies_de_recours",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => 'Exercising legal remedies',
                                                    "fields" => [
                                                        ["name" => "completed_at", "type" => "date", "label" => "Date of appeal", "required" => true],
                                                        ["name" => "documents", "type" => "file", "label" => "Documents de recours", "required" => true],
                                                        [ "name" => "recourse_is_favorable", "type" => "radio", "label" => "Is the appeal favorable?", "required" => true],
                                                    ]
                                                ]
                                                    ],
                                            "options" => [
                                                "yes" => [
                                                    [
                                                        "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
                                                        "code" => "transmission_notaire_demande_inscription_garantie_rccm",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => 'Transmission to the notary of a request for registration of the guarantee with the RCCM',
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of transmission", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents de transmission", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ],
                                                    [
                                                        "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
                                                        "code" => "envoi_demande_notaire_rccm_enregistrement_garantie",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of sending", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents d'envoi", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ],
                                                    [
                                                        "title" => 'Receipt of proof of registration of the guarantee',
                                                        "code" => "reception_preuve_inscription_garantie",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => 'Receipt of proof of registration of the guarantee',
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of receipt", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                                ],
                                                "no" => [
                                                     [
                                                        "title" => 'Obtaining another guarantee',
                                                        "code" => "other_guarantee",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                    ]
                                                ]

                                            ]
                                        ]
                                    ]


                                    ]
                                ]

                    ],
                ],
            "realization" => [

                "title" => 'Payment order',
                "code" => "command_to_pay",
                "min_delay" => null,
                "max_delay" => 10,
                "extra" => [
                    "form" => [
                        "title" => 'Payment order',
                        "fields" => [
                            ["name" => "completed_at", "type" => "date", "label" => "Date of command", "required" => true],
                            ["name" => "documents", "type" => "file", "label" => "Documents de commandement", "required" => true],
                            ["name" => "is_fruitful", "type" => "radio", "label" => "Was the command successful?", "required" => true],

                        ]
                    ]
                ],
                "options" => [
                    "yes" => [
                        [
                            "title" => 'Cancellation of the registration',
                            "code" => "deletion_registration",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => 'Cancellation of the registration',
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of cancellation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                    ],

                    "no"  => [
                        [
                            "title" => 'Practicing a conservatory seizure',
                            "code" => "saisie_conservatoire",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => 'Practicing a conservatory seizure',
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of seizure", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Referral to the notary for notification to the debtor of the conservatory seizure",
                            "code" => "denonciation_debiteur",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Referral to the notary for notification to the debtor of the conservatory seizure",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Obtaining proof of notification",
                            "code" => "denonciation_proof",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Obtaining proof of notification",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true],
                                        ["name" => "favorable_response", "type" => "radio", "label" => "Is the outcome favorable?", "required" => true],
                                    ]
                                ]
                            ],
                            "options" => [
                                "yes" => [
                                    [
                                        "title" => "Referral to the court for conversion to seizure-sale",
                                        "code" => "inscription_radiation",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Radiation de l'inscription",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of cancellation", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                ],
                                "no" => [
                                    [
                                        "title" => "Referral to the court for conversion to seizure-sale",
                                        "code" => "jurisdiction_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Referral to the court for conversion to seizure-sale",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtaining proof of conversion to seizure-sale",
                                        "code" => "proof_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de conversion en saisie-vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Referral to the notary for serving the act of conversion",
                                        "code" => "notary_act_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Saisine du notaire pour signification de l'acte de conversion",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtaining proof of serving the act of conversion by the notary",
                                        "code" => "proof_notary_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de signification de l'acte de conversion par le notaire",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Sale",
                                        "code" => "sale",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Sale",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of sale", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true],
                                                    ["name" => "is_friendly", "type" => "radio", "label" => "Is the sale amicable?", "required" => true]
                                                ]
                                            ]
                                                ],
                                        "options" => [
                                            "yes" => [],
                                            "no" => [
                                                [
                                                    "title" => "Notification of the sale date to the debtor and opposing creditors",
                                                    "code" => "sale_date_notification",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Notification of the sale date to the debtor and opposing creditors",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of notification", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de notification", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Referral to the notary for publicity formalities",
                                                    "code" => "notary_publicity_formalities",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Referral to the notary for publicity formalities",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Distribution of the sale price",
                                                    "code" => "sale_price_distribution",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Distribution of the sale price",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of distribution", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de distribution", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Forced sale of the stock",
                                                    "code" => "forced_stock_sale",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Forced sale of the stock",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of forced sale", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de vente", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ]

                                            ]
                                        ]
                                    ]

                                ]
                            ]

                        ],


                    ]
                ]

            ],
        ];
    }

    public function defaultVehicleSteps() : array {
        return [
            "formalization" => [
                    [
                        "title" => "Initiation of the guarantee",
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 0,
                    ],
                    [
                        "title" => "Obtaining property documents",
                        "code" => "obtention",
                        "min_delay" => null,
                        "max_delay" => 0,
                    ],
                    [
                        "title" => "Drafting of the guarantee agreement",
                        "code" => "redaction",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Drafting of the guarantee agreement",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of the agreement",
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
                        "title" => "Deposit of the agreement with the notary",
                        "code" => "notary_deposit",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Deposit of the agreement with the notary",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of deposit of the agreement",
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
                        "title" => "Transmission to the notary of a request for registration of the guarantee with the RCCM",
                        "code" => "notary_transmission",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Transmission to the notary of a request for registration of the guarantee with the RCCM",
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
                                        "label" => "Documents",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => "Obtaining the registered guarantee agreement",
                        "code" => "convention_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Obtaining the registered guarantee agreement",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of obtaining",
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
                        "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
                        "code" => "rccm_registration",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Sending a request by the notary to the RCCM for registration of the guarantee',
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
                                        "label" => "Documents",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => 'Receipt of proof of registration of the guarantee',
                        "code" => "rccm_proof",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => 'Receipt of proof of registration of the guarantee',
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of receipt",
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
                        "title" => "Referral to the bailiff for notifications and/or domiciliation formalities with 'favorable declaration' notice",
                        "code" => "huissier_notification",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Referral to the bailiff for notifications and/or domiciliation formalities with 'favorable declaration' notice",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of referral",
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
                        "title" => "Obtaining domiciliation acts with 'favorable declaration' notice",
                        "code" => "domiciliation_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Obtaining domiciliation acts with 'favorable declaration' notice",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date of obtaining",
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
            "realization" => [

                "title" => "Payment order",
                "code" => "command_to_pay",
                "min_delay" => null,
                "max_delay" => 10,
                "extra" => [
                    "form" => [
                        "title" => "Payment order",
                        "fields" => [
                            ["name" => "completed_at", "type" => "date", "label" => "Date of command", "required" => true],
                            ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true],
                            ["name" => "is_fruitful", "type" => "radio", "label" => "Was the command successful?", "required" => true],

                        ]
                    ]
                ],
                "options" => [
                    "yes" => [
                        [
                            "title" => "Cancellation of the registration",
                            "code" => "deletion_registration",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Cancellation of the registration",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of cancellation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                    ],
                    //TODO : update convenient info
                    "no"  => [
                        [
                            "title" => "Practicing a conservatory seizure",
                            "code" => "saisie_conservatoire",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Practicing a conservatory seizure",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of seizure", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Referral to the notary for notification to the debtor of the conservatory seizure",
                            "code" => "denonciation_debiteur",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Referral to the notary for notification to the debtor of the conservatory seizure",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Obtaining proof of notification",
                            "code" => "denonciation_proof",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Obtaining proof of notification",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true],
                                        ["name" => "favorable_response", "type" => "radio", "label" => "La suite est elle favorable ?", "required" => true],
                                    ]
                                ]
                            ],
                            "options" => [
                                "yes" => [
                                    [
                                        "title" => "Cancellation of the registration",
                                        "code" => "inscription_radiation",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Cancellation of the registration",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of cancellation", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                ],
                                "no" => [
                                    [
                                        "title" => "Referral to the court for conversion to seizure-sale",
                                        "code" => "jurisdiction_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Referral to the court for conversion to seizure-sale",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtaining proof of conversion to seizure-sale",
                                        "code" => "proof_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtaining proof of conversion to seizure-sale",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Referral to the notary for serving the act of conversion",
                                        "code" => "notary_act_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Referral to the notary for serving the act of conversion",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtaining proof of serving the act of conversion by the notary",
                                        "code" => "proof_notary_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtaining proof of serving the act of conversion by the notary",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of obtaining", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Sale",
                                        "code" => "sale",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Sale",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date of sale", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents", "required" => true],
                                                    ["name" => "is_friendly", "type" => "radio", "label" => "Is the sale amicable?", "required" => true]
                                                ]
                                            ]
                                                ],
                                        "options" => [
                                            "yes" => [],
                                            "no" => [
                                                [
                                                    "title" => "Notification of the sale date to the debtor and opposing creditors",
                                                    "code" => "sale_date_notification",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Notification of the sale date to the debtor and opposing creditors",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of notification", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de notification", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Referral to the notary for publicity formalities",
                                                    "code" => "notary_publicity_formalities",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Referral to the notary for publicity formalities",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of referral", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Distribution of the sale price",
                                                    "code" => "sale_price_distribution",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Distribution of the sale price",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of distribution", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de distribution", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Forced sale of the stock",
                                                    "code" => "forced_stock_sale",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Forced sale of the stock",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date of forced sale", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de vente", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ]

                                            ]
                                        ]
                                    ]

                                ]
                            ]

                        ],


                    ]
                ]

            ],
            ];
    }
}
