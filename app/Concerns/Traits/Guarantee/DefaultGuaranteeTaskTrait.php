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
                        "title" => "Iniation de la garantie",
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 0,
                    ],
                    [
                        "title" => "Rédaction de la convention de garantie",
                        "code" => "redaction",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Rédaction de la convention de garantie",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de la convention",
                                        "required" => true
                                    ],
                                    [
                                        "name" => "documents",
                                        "type" => "file",
                                        "label" => "Date de la convention",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => "Dépot de la convention au rang des minutes d'un notaire",
                        "code" => "notary_deposit",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Dépot de la convention au rang des minutes d'un notaire",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de dépot de la convention",
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
                        "title" => "Transmission au notaire d'une demande d'incription de la garantie au RCCM",
                        "code" => "notary_transmission",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Transmission au notaire d'une demande d'incription de la garantie au RCCM",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de transmission",
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
                        "title" => "Obtention de la convention de garantie enregistrée",
                        "code" => "convention_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Obtention de la convention de garantie enregistrée",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date d'obtention",
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
                        "title" => "Envoi d'une demande par le notaire au RCCM pour enregistrement de la garantie",
                        "code" => "rccm_registration",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Envoi d'une demande par le notaire au RCCM pour enregistrement de la garantie",
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
                                        "label" => "Documents",
                                        "required" => true
                                    ],

                                ]
                            ]
                        ]
                    ],
                    [
                        "title" => "Réception de la preuve d'inscription de la garantie",
                        "code" => "rccm_proof",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Réception de la preuve d'inscription de la garantie",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de réception",
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
                        "title" => "Saisine de l'huissier pour les notifications et/ou les formalités de domiciliation avec l'avis 'déclaration favorable'",
                        "code" => "huissier_notification",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Saisine de l'huissier pour les notifications et/ou les formalités de domiciliation avec l'avis 'déclaration favorable'",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de saisine",
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
                        "title" => "Obtention des actes de domiciliation avec l'avis 'déclaration favorable'",
                        "code" => "domiciliation_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Obtention des actes de domiciliation avec l'avis 'déclaration favorable'",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date d'obtention",
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
                        "title" => "Obtention du bordereau de gage de stocks émis par le greffier au débiteur",
                        "code" => "stock_pledge_obtention",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Obtention du bordereau de gage de stocks émis par le greffier au débiteur",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date d'obtention",
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
                        "title" => "Iniation de la garantie",
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 10,
                    ],
                    [
                        "title" => "Saisine de la juridiction compétente",
                        "code" => "referral",
                        "min_delay" => null,
                        "max_delay" => 10,
                        "extra" => [
                            "form" => [
                                "title" => "Saisine de la juridiction compétente",
                                "fields" => [
                                    [
                                        "name" => "completed_at",
                                        "type" => "date",
                                        "label" => "Date de saisine",
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
                        ],
                        "options" => [
                                    "yes" => [
                                        [
                                            "title" => "Obtenir la décision autorisant la garantie",
                                            "code" => "obtenir_decision_autorisant_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Obtenir la décision autorisant la garantie",
                                                    "fields" => [
                                                        [
                                                            "name" => "completed_at",
                                                            "type" => "date",
                                                            "label" => "Date de décision",
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
                                            "title" => "Transmission au notaire d'une demande d'inscription de la garantie au RCCM",
                                            "code" => "transmission_notaire_demande_inscription_garantie_rccm",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Transmission au notaire d'une demande d'inscription de la garantie au RCCM",
                                                    "fields" => [
                                                        [
                                                            "name" => "completed_at",
                                                            "type" => "date",
                                                            "label" => "Date de transmission",
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
                                            "title" => "Envoi d'une demande par le notaire au RCCM pour enregistrement de la garantie",
                                            "code" => "envoi_demande_notaire_rccm_enregistrement_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Envoi d'une demande par le notaire au RCCM pour enregistrement de la garantie",
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
                                                            "label" => "Documents d'envoi",
                                                            "required" => true
                                                        ],
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "title" => "Réception de la preuve d'inscription de la garantie",
                                            "code" => "reception_preuve_inscription_garantie",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Réception de la preuve d'inscription de la garantie",
                                                    "fields" => [
                                                        [
                                                            "name" => "completed_at",
                                                            "type" => "date",
                                                            "label" => "Date de réception",
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
                                            "title" => "Décision non favorable",
                                            "code" => "decision_non_favorable",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Décision non favorable",
                                                    "fields" => [
                                                        ["name" => "completed_at", "type" => "date", "label" => "Date de décision", "required" => true],
                                                        ["name" => "documents", "type" => "file", "label" => "Documents de décision", "required" => true]
                                                    ]
                                                ]
                                            ]
                                        ],
                                        [
                                            "title" => "Exercer les voies de recours",
                                            "code" => "exercer_les_voies_de_recours",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Exercer les voies de recours",
                                                    "fields" => [
                                                        ["name" => "completed_at", "type" => "date", "label" => "Date de recours", "required" => true],
                                                        ["name" => "documents", "type" => "file", "label" => "Documents de recours", "required" => true]
                                                    ]
                                                ]
                                                    ],
                                            "options" => [
                                                "yes" => [
                                                    [
                                                        "title" => "Transmission au notaire d'une demande d'inscription de la garantie au RCCM",
                                                        "code" => "transmission_notaire_demande_inscription_garantie_rccm",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => "Transmission au notaire d'une demande d'inscription de la garantie au RCCM",
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de transmission", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents de transmission", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ],
                                                    [
                                                        "title" => "Envoi d'une demande par le notaire au RCCM pour enrégistrement de la garantie",
                                                        "code" => "envoi_demande_notaire_rccm_enregistrement_garantie",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => "Envoi d'une demande par le notaire au RCCM pour enrégistrement de la garantie",
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date d'envoi", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents d'envoi", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ],
                                                    [
                                                        "title" => "Réception de la preuve d'inscription de la garantie",
                                                        "code" => "reception_preuve_inscription_garantie",
                                                        "min_delay" => null,
                                                        "max_delay" => 10,
                                                        "extra" => [
                                                            "form" => [
                                                                "title" => "Réception de la preuve d'inscription de la garantie",
                                                                "fields" => [
                                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de réception", "required" => true],
                                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                                ],
                                                "no" => [
                                                     [
                                                        "title" => "Obtenir une autre garantie",
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
            "realization" => [],
            ];
    }

    public function getStockSteps()
    {
        $steps =  [
            [
                'title' => 'Initiation de la garantie',
                'code' => 'created',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'initiation',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => null
            ],
            [
                'title' => 'Rédaction de la convention de garantie',
                'code' => 'redaction',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Dépot de la convention au rang des minutes d\'un notaire',
                'code' => 'notary_deposit',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Transmission au notaire d\'une demande d\'incription de la garantie au RCCM',
                'code' => 'notary_transmission',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention de la convention de garantie enregistrée',
                'code' => 'convention_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Envoi d\'une demande par le notaire au RCCM pour enregistrement de la garantie',
                'code' => 'rccm_registration',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 6,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Réception de la preuve d\'inscription de la garantie',
                'code' => 'rccm_proof',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 7,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],

            [
                'title' => 'Saisine de l\'huissier pour les notifications et/ou les formalités de domiciliation avec l\'avis "déclaration favorable"',
                'code' => 'huissier_notification',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 8,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention des actes de domiciliation avec l\'avis "déclaration favorable"',
                'code' => 'domiciliation_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 9,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],
            [
                'title' => 'Obtention du bordereau de gage de stocks émis par le greffier au débiteur',
                'code' => 'stock_pledge_obtention',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 10,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'conventionnal'
            ],

            //legal formalization type
            [
                'title' => 'Saisine de la juridiction compétente',
                'code' => 'referral',
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => 10,
                'formalization_type' => 'legal'
            ],
            /* [
                'title' => 'Obtention de la décision autorisant la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'obtention',
                'rank' => 1,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Transmission au notaire d\'une demande d\'inscription de la garantie au RCCM',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 2,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Envoi d\'une demande par le notaire au RCCM pour enregistrement de la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'formalization',
                'rank' => 3,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Réception de la preuve d\'inscription de la garantie',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'obtention',
                'rank' => 4,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => null
            ],
            [
                'title' => 'Autorisation judiciaire',
                'code' => null,
                'guarantee_type' => GuaranteeType::STOCK,
                'step_type' => 'legal',
                'rank' => 5,
                'min_delay' => null,
                'max_delay' => null,
                'formalization_type' => 'legal'
            ], */

            //

        ];


        return collect($steps);
    }
}
