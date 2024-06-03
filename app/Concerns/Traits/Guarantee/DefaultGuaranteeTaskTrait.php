<?php

namespace App\Concerns\Traits\Guarantee;

use App\Enums\Guarantee\GuaranteeType;

trait DefaultGuaranteeTaskTrait
{
    public function defaultStockSteps() : array {
        return [
            "formalization" => [
                "conventionnal" => [
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
                                        "label" => "Documents de la convention",
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
                                    [
                                        "name" => "is_favorable",
                                        "type" => "radio",
                                        "label" => "La décision est-elle favorable ?",
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
                                            "title" => "Exercer les voies de recours",
                                            "code" => "exercer_les_voies_de_recours",
                                            "min_delay" => null,
                                            "max_delay" => 10,
                                            "extra" => [
                                                "form" => [
                                                    "title" => "Exercer les voies de recours",
                                                    "fields" => [
                                                        ["name" => "completed_at", "type" => "date", "label" => "Date de recours", "required" => true],
                                                        ["name" => "documents", "type" => "file", "label" => "Documents de recours", "required" => true],
                                                        [ "name" => "recourse_is_favorable", "type" => "radio", "label" => "Le recours est-il favorable ?", "required" => true],
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
            "realization" => [

                "title" => "Commandement de payer",
                "code" => "command_to_pay",
                "min_delay" => null,
                "max_delay" => 10,
                "extra" => [
                    "form" => [
                        "title" => "Commandement de payer",
                        "fields" => [
                            ["name" => "completed_at", "type" => "date", "label" => "Date de commandement", "required" => true],
                            ["name" => "documents", "type" => "file", "label" => "Documents de commandement", "required" => true],
                            ["name" => "is_fruitful", "type" => "radio", "label" => "Le commendement a été fructueux ?", "required" => true],

                        ]
                    ]
                ],
                "options" => [
                    "yes" => [
                        [
                            "title" => "Radiation de l'inscription",
                            "code" => "deletion_registration",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Radiation de l'inscription",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                    ],

                    "no"  => [
                        [
                            "title" => "Pratiquer une saisie conservatoire",
                            "code" => "saisie_conservatoire",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Saisie conservatoire",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => " Saisine du Notaire pour dénonciation au débiteur de la saisie conservatoire",
                            "code" => "denonciation_debiteur",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Saisine du notaire",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Obtention de la preuve de la dénonciation",
                            "code" => "denonciation_proof",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Preuve de la dénonciation",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true],
                                        ["name" => "favorable_response", "type" => "radio", "label" => "La suite est elle favorable ?", "required" => true],
                                    ]
                                ]
                            ],
                            "options" => [
                                "yes" => [
                                    [
                                        "title" => "Radiation de l'inscription",
                                        "code" => "inscription_radiation",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Radiation de l'inscription",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                ],
                                "no" => [
                                    [
                                        "title" => "Saisine de la juridiction pour conversion en saisie-vente",
                                        "code" => "jurisdiction_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Saisine de la juridiction pour conversion en saisie-vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtention de la preuve de conversion en saisie-vente",
                                        "code" => "proof_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de conversion en saisie-vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date d'obtention", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Saisine du notaire pour signification de l'acte de conversion",
                                        "code" => "notary_act_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Saisine du notaire pour signification de l'acte de conversion",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtention de la preuve de signification de l'acte de conversion par le notaire",
                                        "code" => "proof_notary_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de signification de l'acte de conversion par le notaire",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date d'obtention", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Vente",
                                        "code" => "sale",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de vente", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true],
                                                    ["name" => "is_friendly", "type" => "radio", "label" => "La vente est-elle amiable ?", "required" => true]
                                                ]
                                            ]
                                                ],
                                        "options" => [
                                            "yes" => [],
                                            "no" => [
                                                [
                                                    "title" => "Notification de la date de vente au débiteur et aux créanciers opposants",
                                                    "code" => "sale_date_notification",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Notification de la date de vente au débiteur et aux créanciers opposants",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de notification", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de notification", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Saisine du notaire pour les formalités de publicité",
                                                    "code" => "notary_publicity_formalities",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Saisine du notaire pour les formalités de publicité",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Distribution du prix de vente",
                                                    "code" => "sale_price_distribution",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Distribution du prix de vente",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de distribution", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de distribution", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Vente forcée du stock",
                                                    "code" => "forced_stock_sale",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Vente forcée du stock",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de vente forcée", "required" => true],
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
                        "title" => "Iniation de la garantie",
                        "code" => "created",
                        "min_delay" => null,
                        "max_delay" => 0,
                    ],
                    [
                        "title" => "Obtention des documents de propriété",
                        "code" => "obtention",
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

                ],
            "realization" => [

                "title" => "Commandement de payer",
                "code" => "command_to_pay",
                "min_delay" => null,
                "max_delay" => 10,
                "extra" => [
                    "form" => [
                        "title" => "Commandement de payer",
                        "fields" => [
                            ["name" => "completed_at", "type" => "date", "label" => "Date de commandement", "required" => true],
                            ["name" => "documents", "type" => "file", "label" => "Documents de commandement", "required" => true],
                            ["name" => "is_fruitful", "type" => "radio", "label" => "Le commendement a été fructueux ?", "required" => true],

                        ]
                    ]
                ],
                "options" => [
                    "yes" => [
                        [
                            "title" => "Radiation de l'inscription",
                            "code" => "deletion_registration",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Radiation de l'inscription",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                    ],
                    //TODO : update convenient info
                    "no"  => [
                        [
                            "title" => "Pratiquer une saisie conservatoire",
                            "code" => "saisie_conservatoire",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Saisie conservatoire",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => " Saisine du Notaire pour dénonciation au débiteur de la saisie conservatoire",
                            "code" => "denonciation_debiteur",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Saisine du notaire",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "title" => "Obtention de la preuve de la dénonciation",
                            "code" => "denonciation_proof",
                            "min_delay" => null,
                            "max_delay" => 10,
                            "extra" => [
                                "form" => [
                                    "title" => "Preuve de la dénonciation",
                                    "fields" => [
                                        ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                        ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true],
                                        ["name" => "favorable_response", "type" => "radio", "label" => "La suite est elle favorable ?", "required" => true],
                                    ]
                                ]
                            ],
                            "options" => [
                                "yes" => [
                                    [
                                        "title" => "Radiation de l'inscription",
                                        "code" => "inscription_radiation",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Radiation de l'inscription",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de radiation", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de radiation", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                ],
                                "no" => [
                                    [
                                        "title" => "Saisine de la juridiction pour conversion en saisie-vente",
                                        "code" => "jurisdiction_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Saisine de la juridiction pour conversion en saisie-vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtention de la preuve de conversion en saisie-vente",
                                        "code" => "proof_seizure_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de conversion en saisie-vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date d'obtention", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Saisine du notaire pour signification de l'acte de conversion",
                                        "code" => "notary_act_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Saisine du notaire pour signification de l'acte de conversion",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Obtention de la preuve de signification de l'acte de conversion par le notaire",
                                        "code" => "proof_notary_conversion",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Obtention de la preuve de signification de l'acte de conversion par le notaire",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date d'obtention", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "title" => "Vente",
                                        "code" => "sale",
                                        "min_delay" => null,
                                        "max_delay" => 10,
                                        "extra" => [
                                            "form" => [
                                                "title" => "Vente",
                                                "fields" => [
                                                    ["name" => "completed_at", "type" => "date", "label" => "Date de vente", "required" => true],
                                                    ["name" => "documents", "type" => "file", "label" => "Documents de preuve", "required" => true],
                                                    ["name" => "is_friendly", "type" => "radio", "label" => "La vente est-elle amiable ?", "required" => true]
                                                ]
                                            ]
                                                ],
                                        "options" => [
                                            "yes" => [],
                                            "no" => [
                                                [
                                                    "title" => "Notification de la date de vente au débiteur et aux créanciers opposants",
                                                    "code" => "sale_date_notification",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Notification de la date de vente au débiteur et aux créanciers opposants",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de notification", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de notification", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Saisine du notaire pour les formalités de publicité",
                                                    "code" => "notary_publicity_formalities",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Saisine du notaire pour les formalités de publicité",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de saisine", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de saisine", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Distribution du prix de vente",
                                                    "code" => "sale_price_distribution",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Distribution du prix de vente",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de distribution", "required" => true],
                                                                ["name" => "documents", "type" => "file", "label" => "Documents de distribution", "required" => true]
                                                            ]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "title" => "Vente forcée du stock",
                                                    "code" => "forced_stock_sale",
                                                    "min_delay" => null,
                                                    "max_delay" => 10,
                                                    "extra" => [
                                                        "form" => [
                                                            "title" => "Vente forcée du stock",
                                                            "fields" => [
                                                                ["name" => "completed_at", "type" => "date", "label" => "Date de vente forcée", "required" => true],
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
