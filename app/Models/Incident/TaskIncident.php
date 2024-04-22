<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TaskIncident extends Model
{
    use HasFactory, HasUuids;

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
    ];

    const CHANNELS = [
        'email',
        'call',
    ];

    const TASKS = [
        'avis-tiers-detenteurs' => [
            true => [
                'atd_1' => [
                        'title' => 'Prendre des mesures conservatoires avec les Cso (Bloquer les fonds sur le compte)',
                        'rules' => [
                            'date' => ['required', 'date'],
                            'info_channel' => ['required', 'in:email,call'],
                            'info_channel_value' => ['required', 'string'],
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'select',
                                    'name' => 'info_channel',
                                    'label' => 'Cannal d\'information',
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
                            'form_title' => 'Informations sur le blocage des fonds'
                        ],
                    ],
                'atd_2' => [
                        'title' => 'Adresser un courrier d\'information au client',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information au client',
                                ]
                            ],
                            'form_title' => 'Preuve d\'information du client par courrier'
                        ],
                    ],
                'atd_3' => [
                        'title' => 'Transmission d\'une lettre signee par la DG de la banque et de l\'accuse de reception signe',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Lettre signée par la DG & Accusé de réception signé',
                                ]
                            ],
                            'form_title' => 'Preuve de la transmission de la lettre'
                        ],
                    ],
                'atd_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous recu de Main levee ?',
                                ]
                            ],
                            'form_title' => 'Réception de la main levée'
                        ],
                        "next" => [
                            true => [
                                'atd_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Attacher le document de la main levée',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de réception de la main levée'
                                        ],
                                    ],
                                'atd_4_2' => [
                                        'title' => 'Levee des mesures conservatoires et restitution des fonds bloques sur le compte du client',
                                        'rules' => [
                                            'date' => ['required', 'date'],
                                            'info_channel' => ['required', 'in:email,call'],
                                            'info_channel_value' => ['required', 'string'],
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'select',
                                                    'name' => 'info_channel',
                                                    'label' => 'Cannal d\'information',
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
                                            'form_title' => 'Preuves de la levee des mesures conservatoires'
                                        ],
                                    ],
                                'atd_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information au client',
                                                ]
                                            ],
                                            'form_title' => 'Preuve d\'information du client par courrier'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'atd_4_4' => [
                                        'title' => 'Reception d\'un avis d\'execution de l\'administration fiscale par Labanque',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Avis d\'execution de l\'administration fiscale',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de la réception de l\'avis'
                                        ],
                                    ],
                                'atd_4_4' => [
                                        'title' => 'Etablissement d\'un cheque à l\'ordre de \'adm fiscale à concurrence du montant saisi',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre une copie du chèque',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de l\'établissement du chèque'
                                        ],
                                    ],
                                'atd_5_5' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information au client',
                                                ]
                                            ],
                                            'form_title' => 'Preuve d\'information du client par courrier'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                        ],
                    ],

            ],
            false => [

                'atd_6' => [
                        'title' => 'Rediger un courrier à l\'adresse de l\'ADM Fiscale à signer par la DG de la banque',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier à l\'adresse de l\'ADM Fiscale',
                                ]
                            ],
                            'form_title' => 'Preuve de la transmission du courrier à l\'ADM Fiscale'
                        ],
                        "next" => false,
                    ],
            ],
        ],
        'requisition' => [
            true => [
                'req_1' => [
                        'title' => ' Attacher le courrier d`\'information du client à signer par la DG de la banque',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information au client',
                                ]
                            ],
                            'form_title' => 'Preuve d\'information du client par courrier'
                        ],
                    ],
                'req_2' => [
                        'title' => 'Attacher le courrier de transmission signee par la DG de la banque',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier de transmission signee',
                                ]
                            ],
                            'form_title' => 'Preuve de la transmission du courrier à l\'ADM Fiscale'
                        ],
                        "next" => false,
                    ],
            ],
            false => [
                'req_3' => [
                        'title' => 'Rediger un courrier à l\'adresse de l\'autorité concernée à signer par la DG de la banque',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier signée à l\'adresse de l\'autorité concernée',
                                ]
                            ],
                            'form_title' => 'Preuve de l\'envoi du courrier à l\'autorité concernée'
                        ],
                        "next" => false,
                    ],
            ],
        ],
        'saisie-conservatoire' => [
            true => [
                'sc_1' => [
                        'title' => 'Declarer la nature et le solde des comptes du client sur l\'acte d\'huissier',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'Preuve de la fiche de déclaration'
                        ],
                    ],
                'sc_2' => [
                        'title' => 'Remplir une fiche de prelement signe par le responsable juridique a adresser a la direction des operations',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de prelevement',
                                ]
                            ],
                            'form_title' => 'Attacher la fiche de paiement'
                        ],
                    ],
                'sc_3' => [
                        'title' => 'Infomer le client concerne par telecall ou courrier',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information du client',
                                ]
                            ],
                            'form_title' => 'Preuve du courrier d\'information'
                        ],
                    ],
                'sc_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous recu de Main levee ?',
                                ]
                            ],
                            'form_title' => 'Réception de la main levée'
                        ],
                        "next" => [
                            true => [
                                'sc_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le document de la main levee',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de réception de la main levée'
                                        ],
                                    ],
                                'sc_4_2' => [
                                        'title' => 'Levee des restriction du compte client',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre la preuve de la levee des restrictions',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de la levee des restrictions'
                                        ],
                                    ],
                                'sc_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de l\'envoi du courrier au client'
                                        ],
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'sc_4_4' => [
                                    'title' => 'Joindre l\'acte de conversion',
                                    'rules' => [
                                        'conversion_certificate' => ['required', 'in:yes,no'],
                                        // 'documents' => ['required', 'array'],
                                        // 'documents.*.name' => ['required', 'string'],
                                        // 'documents.*.file' => ['required', 'file'],
                                    ],
                                    "delay" => 0,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'radio',
                                                'name' => 'conversion_certificate',
                                                'label' => 'Avez vous recu l\'acte de conversion ?',
                                            ],
                                            // [
                                            //     'type' => 'documents',
                                            //     'name' => 'documents',
                                            //     'label' => 'Joindre le courrier d\'information du client',
                                            // ]
                                        ],
                                        'form_title' => 'Réception de l\'acte de conversion'
                                    ],
                                    "next" => [
                                        false => [
                                            'sc_4_4_1' => [
                                                    'title' => 'Caducite de la saisie en l\'absence de la presentation d\'un titre executoire',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 0,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre la caducite de la saisie',
                                                            ]
                                                        ],
                                                        'form_title' => 'Preuve de la caducité de la saisie'
                                                    ],
                                                ],
                                            'sc_4_4_2' => [
                                                    'title' => 'Attachement de la main levée de la saisie',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 0,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Attacher le document de la main levée',
                                                            ]
                                                        ],
                                                        'form_title' => 'Preuve de la main levée de la saisie'
                                                    ],
                                                    "next" => false,
                                                ],
                                        ],
                                        true => [
                                            'sc_4_4_3' => [
                                                    'title' => 'Presentation d\'un titre executoire, d\'un acte de conversion de saisie conservatoire en saisie attribution et d\'une preuve d\'absence d\'opposition',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 0,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre les documents',
                                                            ]
                                                        ],
                                                        'form_title' => 'Preuve de la liste des documents'
                                                    ],
                                                ],
                                            'sc_4_4_4' => [
                                                    'title' => 'Paiement du creancier par l\'etablissement d\'un cheque',
                                                    'rules' => [
                                                        'documents' => ['required', 'array'],
                                                        'documents.*.name' => ['required', 'string'],
                                                        'documents.*.file' => ['required', 'file']
                                                    ],
                                                    "delay" => 0,
                                                    "form" => [
                                                        'fields' => [
                                                            [
                                                                'type' => 'documents',
                                                                'name' => 'documents',
                                                                'label' => 'Joindre la fiche de paiement du creancier',
                                                            ]
                                                        ],
                                                        'form_title' => 'Preuve de paiement du creancier'
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
                        'title' => 'Declaration signee de l\'agent sur l\'acte d\'huissier',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'Preuve de la déclaration de l\'agent'
                        ],
                        "next" => false,
                    ],

            ],
        ],
        'saisie-attribution' => [
            true => [
                'sa_1' => [
                        'title' => 'Declarer la nature et le solde des comptes du client sur l\'acte d\'huissier',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre la fiche de déclaration',
                                ]
                            ],
                            'form_title' => 'Preuve de la fiche de déclaration'
                        ],
                    ],
                'sa_2' => [
                        'title' => 'Remplir une fiche de prelement signe par le responsable juridique a adresser a la direction des operations',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joinndre la fiche de prelevement',
                                ]
                            ],
                            'form_title' => 'Preuve de la fiche de paiement'
                        ],
                    ],
                'sa_3' => [
                        'title' => 'Infomer le client concerne par telecall ou courrier',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre le courrier d\'information du client',
                                ]
                            ],
                            'form_title' => 'Preuve de l\'envoi du courrier au client'
                        ],
                    ],
                'sa_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                            'raised_hand' => ['required', 'in:yes,no'],
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'radio',
                                    'name' => 'raised_hand',
                                    'label' => 'Avez vous recu de Main levee ?',
                                ]
                            ],
                            'form_title' => 'Réception de la main levée'
                        ],
                        "next" => [
                            true => [
                                'sa_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le document de la main levee',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de réception de la main levée'
                                        ],
                                    ],
                                'sa_4_2' => [
                                        'title' => 'Levee des restriction du compte client',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre la preuve de la levee des restrictions',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de la levee des restrictions'
                                        ],
                                    ],
                                'sa_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de l\'envoi du courrier au client'
                                        ],
                                        "next" => false,
                                ],
                            ],
                            false => [
                                'sa_4_4' => [
                                    'title' => 'Presentation par le creancier d\'un certificat du greffe portant comandement de payer (dans un delai 1 mois)',
                                    'rules' => [
                                        'documents' => ['required', 'array'],
                                        'documents.*.name' => ['required', 'string'],
                                        'documents.*.file' => ['required', 'file']
                                    ],
                                    "delay" => 0,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'documents',
                                                'name' => 'documents',
                                                'label' => 'Joindre la caducite de la saisie',
                                            ]
                                        ],
                                        'form_title' => 'Preuve du certificat du greffe'
                                    ],
                                ],
                                'sa_4_5' => [
                                    'title' => 'Etablir un cheque au nom du creancier ou son mandataire dans la limite du montant saisi',
                                    'rules' => [
                                        'documents' => ['required', 'array'],
                                        'documents.*.name' => ['required', 'string'],
                                        'documents.*.file' => ['required', 'file']
                                    ],
                                    "delay" => 0,
                                    "form" => [
                                        'fields' => [
                                            [
                                                'type' => 'documents',
                                                'name' => 'documents',
                                                'label' => 'Joindre la copie du chèque',
                                            ]
                                        ],
                                        'form_title' => 'Preuve de l\'établissement du chèque'
                                    ],
                                ],
                                'sa_4_6' => [
                                        'title' => 'Informer le client',
                                        'rules' => [
                                            'documents' => ['required', 'array'],
                                            'documents.*.name' => ['required', 'string'],
                                            'documents.*.file' => ['required', 'file']
                                        ],
                                        "delay" => 0,
                                        "form" => [
                                            'fields' => [
                                                [
                                                    'type' => 'documents',
                                                    'name' => 'documents',
                                                    'label' => 'Joindre le courrier d\'information du client',
                                                ]
                                            ],
                                            'form_title' => 'Preuve de l\'envoi du courrier au client'
                                        ],
                                        "next" => false,
                                ],
                            ],
                        ],
                ],

            ],
            false => [
                'sa_5' => [
                        'title' => 'Declaration de l\'agent sur l\'exploit d\'huisser',
                        'rules' => [
                            'documents' => ['required', 'array'],
                            'documents.*.name' => ['required', 'string'],
                            'documents.*.file' => ['required', 'file']
                        ],
                        "delay" => 0,
                        "form" => [
                            'fields' => [
                                [
                                    'type' => 'documents',
                                    'name' => 'documents',
                                    'label' => 'Joindre sur la fiche de déclaration',
                                ]
                            ],
                            'form_title' => ''
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

    public function getFormAttribute() {

        $next_task = searchElementIndice(TaskIncident::TASKS, $this->code);

        $form = $next_task['form'];
        return $form;
    }

}

