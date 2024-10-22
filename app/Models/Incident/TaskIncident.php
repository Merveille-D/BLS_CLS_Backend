<?php

namespace App\Models\Incident;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\TaskIncidentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
#[ObservedBy([TaskIncidentObserver::class])]
class TaskIncident extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'raised_hand' => 'boolean',
        'conversion_certificate' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'info_channel',
        'info_channel_value',
        'date',
        'raised_hand',
        'incident_id',
        'status',
        'code',
        'conversion_certificate',
        'deadline',
        'completed_by',
        'created_by',
    ];

    const CHANNELS = [
        'email',
        'call',
    ];

    const TASKS = [
        'avis-tiers-detenteurs' => [
            true => [
                'atd_1' => [
                        'title' => 'atd_1.title',
                        'rules' => [
                            'date' => ['required', 'date'],
                            'info_channel' => ['required', 'in:email,call'],
                            'info_channel_value' => ['required', 'string'],
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'select',
                                    'name' => 'info_channel',
                                    'label' => 'Canal d\'information',
                                ],
                                [
                                    'type' => 'text',
                                    'name' => 'info_channel_value',
                                    'label' => 'Addresse de l\'information',
                                ],
                                [
                                    'type' => 'date',
                                    'name' => 'date',
                                    'label' => 'Date de blocage',
                                ],
                            ],
                            'form_title' => 'atd_1.form_title'
                        ],
                    ],
                'atd_2' => [
                        'title' => 'atd_2.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information au client',
                                ]
                            ],
                            'form_title' => 'atd_2.form_title'
                        ],
                    ],
                'atd_3' => [
                        'title' => 'atd_3.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la rédaction',
                                ]
                            ],
                            'form_title' => 'atd_3.form_title'
                        ],
                    ],
                'atd_4' => [
                        'title' => 'atd_4.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier validé',
                                ]
                            ],
                            'form_title' => 'atd_4.form_title'
                        ],
                    ],
                'atd_5' => [
                        'title' => 'atd_5.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Lettre signée par la Direction Générale & Accusé de réception signé',
                                ]
                            ],
                            'form_title' => 'atd_5.form_title'
                        ],
                    ],
                'atd_6' => [
                        'title' => 'atd_6.title',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous reçu de main-levée ?',
                                ]
                            ],
                            'form_title' => 'atd_6.form_title'
                        ],
                        "next" => [
                            true => [
                                'atd_6_1' => [
                                        'title' => 'atd_6_1.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Attacher le document de la main-levée',
                                                ]
                                            ],
                                            'form_title' => 'atd_6_1.form_title'
                                        ],
                                    ],
                                'atd_6_2' => [
                                        'title' => 'atd_6_2.title',
                                        'rules' => [
                                            'date' => ['required', 'date'],
                                            'info_channel' => ['required', 'in:email,call'],
                                            'info_channel_value' => ['required', 'string'],
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'select',
                                                    'name' => 'info_channel',
                                                    'label' => 'Canal d\'information',
                                                ],
                                                [
                                                    'type' => 'text',
                                                    'name' => 'info_channel_value',
                                                    'label' => 'Addresse de l\'information',
                                                ],
                                                [
                                                    'type' => 'date',
                                                    'name' => 'date',
                                                    'label' => 'Date de blocage',
                                                ],
                                            ],
                                            'form_title' => 'atd_6_2.form_title'
                                        ],
                                    ],
                                'atd_6_3' => [
                                        'title' => 'atd_6_3.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information au client',
                                                ]
                                            ],
                                            'form_title' => 'atd_6_3.form_title'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'atd_6_4' => [
                                        'title' => 'atd_6_4.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Avis d\'execution de l\'administration fiscale',
                                                ]
                                            ],
                                            'form_title' => 'atd_6_4.form_title'
                                        ],
                                    ],
                                'atd_6_5' => [
                                        'title' => 'atd_6_5.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre une copie du chèque',
                                                ]
                                            ],
                                            'form_title' => 'atd_6_5.form_title'
                                        ],
                                    ],
                                'atd_6_6' => [
                                        'title' => 'atd_6_6.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information au client',
                                                ]
                                            ],
                                            'form_title' => 'atd_6_6.form_title'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                        ],
                    ],

            ],
            false => [

                'atd_7' => [
                        'title' => 'atd_7.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier à l\'adresse de l\'ADM Fiscale',
                                ]
                            ],
                            'form_title' => 'atd_7.form_title'
                        ],
                        "next" => false,
                    ],
            ],
        ],
        'requisition' => [
            true => [
                'req_1' => [
                        'title' => 'req_1.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information au client',
                                ]
                            ],
                            'form_title' => 'req_1.form_title'
                        ],
                    ],
                'req_2' => [
                        'title' => 'req_2.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la rédaction',
                                ]
                            ],
                            'form_title' => 'req_2.form_title'
                        ],
                    ],
                'req_3' => [
                        'title' => 'req_3.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier validé',
                                ]
                            ],
                            'form_title' => 'req_3.form_title'
                        ],
                    ],
                'req_4' => [
                        'title' => 'req_4.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier de transmission signé',
                                ]
                            ],
                            'form_title' => 'req_4.form_title'
                        ],
                        "next" => false,
                    ],
            ],
            false => [
                'req_5' => [
                        'title' => 'req_5.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier signée à l\'adresse de l\'autorité concernée',
                                ]
                            ],
                            'form_title' => 'req_5.form_title'
                        ],
                        "next" => false,
                    ],
            ],
        ],
        'saisie-conservatoire' => [
            true => [
                'sc_1' => [
                        'title' => 'sc_1.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'sc_1.form_title'
                        ],
                    ],
                'sc_2' => [
                        'title' => 'sc_2.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de prelevement',
                                ]
                            ],
                            'form_title' => 'sc_2.form_title'
                        ],
                    ],
                'sc_3' => [
                        'title' => 'sc_3.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information du client',
                                ]
                            ],
                            'form_title' => 'sc_3.form_title'
                        ],
                    ],
                'sc_4' => [
                        'title' => 'sc_4.title',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous reçu de main-levée ?',
                                ]
                            ],
                            'form_title' => 'sc_4.form_title'
                        ],
                        "next" => [
                            true => [
                                'sc_4_1' => [
                                        'title' => 'sc_4_1.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le document de la main-levée',
                                                ]
                                            ],
                                            'form_title' => 'sc_4_1.form_title'
                                        ],
                                    ],
                                'sc_4_2' => [
                                        'title' => 'sc_4_2.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre la preuve de la levée des restrictions',
                                                ]
                                            ],
                                            'form_title' => 'sc_4_2.form_title'
                                        ],
                                    ],
                                'sc_4_3' => [
                                        'title' => 'sc_4_3.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'sc_4_3.form_title'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'sc_4_4' => [
                                    'title' => 'sc_4_4.title',
                                    'rules' => [
                                        'conversion_certificate' => ['required', 'in:yes,no'],
                                    ],
                                    "delay" => 10,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'radio',
                                                'name' => 'conversion_certificate',
                                                'label' => 'Avez vous reçu l\'acte de conversion ?',
                                            ],
                                        ],
                                        'form_title' => 'sc_4_4.form_title'
                                    ],
                                    "next" => [
                                        false => [
                                            'sc_4_4_1' => [
                                                    'title' => 'sc_4_4_1.title',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 10,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre la caducite de la saisie',
                                                            ]
                                                        ],
                                                        'form_title' => 'sc_4_4_1.form_title'
                                                    ],
                                                ],
                                            'sc_4_4_2' => [
                                                    'title' => 'sc_4_4_2.title',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 10,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Attacher le document de la main-levée',
                                                            ]
                                                        ],
                                                        'form_title' => 'sc_4_4_2.form_title'
                                                    ],
                                                    "next" => false,
                                                ],
                                        ],
                                        true => [
                                            'sc_4_4_3' => [
                                                    'title' => 'sc_4_4_3.title',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 10,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre les documents',
                                                            ]
                                                        ],
                                                        'form_title' => 'sc_4_4_3.form_title'
                                                    ],
                                                ],
                                            'sc_4_4_4' => [
                                                    'title' => 'sc_4_4_4.title',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 10,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre la fiche de paiement du creancier',
                                                            ]
                                                        ],
                                                        'form_title' => 'sc_4_4_4.form_title'
                                                    ],
                                                    "next" => false,
                                                ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
            ],
            false => [
                'sc_5' => [
                        'title' => 'sc_5.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'sc_5.form_title'
                        ],
                        "next" => false,
                    ],

            ],
        ],
        'saisie-attribution' => [
            true => [
                'sa_1' => [
                        'title' => 'sa_1.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'sa_1.form_title'
                        ],
                    ],
                'sa_2' => [
                        'title' =>  'sa_2.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joinndre la fiche de prelevement',
                                ]
                            ],
                            'form_title' =>  'sa_2.form_title'
                        ],
                    ],
                'sa_3' => [
                        'title' =>  'sa_3.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information du client',
                                ]
                            ],
                            'form_title' =>  'sa_3.form_title'
                        ],
                    ],
                'sa_4' => [
                        'title' =>  'sa_4.title',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous reçu de main-levée ?',
                                ]
                            ],
                            'form_title' =>  'sa_4.form_title'
                        ],
                        "next" => [
                            true => [
                                'sa_4_1' => [
                                        'title' =>  'sa_4_1.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le document de la main-levée',
                                                ]
                                            ],
                                            'form_title' =>  'sa_4_1.form_title'
                                        ],
                                    ],
                                'sa_4_2' => [
                                        'title' => 'sa_4_2.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre la preuve de la levée des restrictions',
                                                ]
                                            ],
                                            'form_title' => 'sa_4_2.form_title'
                                        ],
                                    ],
                                'sa_4_3' => [
                                        'title' => 'sa_4_3.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'sa_4_3.form_title'
                                        ],
                                        "next" => false,
                                ],
                            ],
                            false => [
                                'sa_4_4' => [
                                    'title' => 'sa_4_4.title',
                                    'rules' => [
                                        'documents' => ['required', 'array'],
                                        'documents.*.name' => ['required', 'string'],
                                        'documents.*.file' => ['required', 'file']
                                    ],
                                    "delay" => 10,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'documents',
                                                'name' => 'documents',
                                                'label' => 'Joindre la caducite de la saisie',
                                            ]
                                        ],
                                        'form_title' => 'sa_4_4.form_title'
                                    ],
                                ],
                                'sa_4_5' => [
                                    'title' => 'sa_4_5.title',
                                    'rules' => [
                                        'documents' => ['required', 'array'],
                                        'documents.*.name' => ['required', 'string'],
                                        'documents.*.file' => ['required', 'file']
                                    ],
                                    "delay" => 10,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'documents',
                                                'name' => 'documents',
                                                'label' => 'Joindre la copie du chèque',
                                            ]
                                        ],
                                        'form_title' => 'sa_4_5.form_title'
                                    ],
                                ],
                                'sa_4_6' => [
                                        'title' => 'sa_4_6.title',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 10,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'sa_4_6.form_title'
                                        ],
                                        "next" => false,
                                ],
                            ],
                        ],
                ],

            ],
            false => [
                'sa_5' => [
                        'title' => 'sa_5.title',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 10,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre sur la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'sa_5.form_title'
                        ],
                        "next" => false,
                    ],
            ],
        ],
    ];

    public function fileUploads()
    {
        return $this->morphMany(IncidentDocument::class, 'uploadable');
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function getFolderAttribute() {
        return $this->incident->title;
    }

    public function getFormAttribute() {

        $next_task = searchElementIndice(TaskIncident::TASKS, $this->code);

        $form = $next_task['form'];
        return $form;
    }

    public function getModuleIdAttribute() : string|null {
        return $this->incident?->id;
    }

    public function getValidationAttribute() {

        return [
            'method' => 'POST',
            'action' => env('APP_URL') . '/api/complete_task_incidents?type=' . $this->code . '&task_incident_id=' . $this->id,
            'form' => $this->form,
        ];
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}

