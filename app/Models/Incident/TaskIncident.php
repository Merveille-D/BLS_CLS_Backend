<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TaskIncident extends Model
{
    use HasFactory;

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'raised_hand' => 'boolean',
        'status' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'info_channel',
        'date',
        'raised_hand',
        'incident_id',
        'status',
        'code',
    ];

    const CHANNELS = [
        'email',
        'phone',
    ];

    const TASKS = [
        'avis-tiers-detenteurs' => [
            true => [
                'atd_1' => [
                        'title' => 'Prendre des mesures conservatoires avec les Cso (Bloquer les fonds sur le compte)',
                        'rules' => [
                            'date' => ['required', 'date'],
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'atd_2' => [
                        'title' => 'Adresser un courrier d\'information au client',
                        'rules' => [
                            'info_channel' => ['required', 'in:email,phone'],
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'atd_3' => [
                        'title' => 'Transmission d\'une lettre signee par la DG de la banque et de l\'accuse de reception signe',
                        'rules' => [
                            'date' => ['required', 'date'],
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'atd_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                            'raised_hand' => ['required', 'boolean'],
                        ],
                        "delay" => 0,
                        "next" => [
                            true => [
                                'atd_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'atd_4_2' => [
                                        'title' => 'Levee des mesures conservatoires et restitution des fonds bloques sur le compte du client',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'atd_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'atd_4_4' => [
                                        'title' => 'Reception d\'un avis d\'execution de l\'administration fiscale par Labanque',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'atd_4_4' => [
                                        'title' => 'Etablissement d\'un cheque à l\'ordre de \'adm fiscale à concurrence du montant saisi',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'atd_5_5' => [
                                        'title' => 'Informer Le
                                        Client Par Un
                                        Courrier',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => false,
                                    ],
                            ],
                        ],
                    ],

            ],
            false => [

                'atd_5' => [
                        'title' => 'Rediger un courrier à l\'adresse de l\'ADM Fiscale à signer par la DG de la banque',
                        'rules' => [
                            'info_channel' => ['required', 'in:email,phone'],
                            'date' => ['required', 'date'],
                        ],
                        "delay" => 0,
                        "next" => false,
                    ],
            ],
        ],
        'requisition' => [
            true => [
                'req_1' => [
                        'title' => ' Attacher le courrier d`\'information du client à signer par la DG de la banque',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'req_2' => [
                        'title' => 'Attacher le courrier de transmission signee par la DG de la banque',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => false,
                    ],
            ],
            false => [
                'req_3' => [
                        'title' => 'Rediger un courrier à l\'adresse de l\'autorité concernée à signer par la DG de la banque',
                        'rules' => [
                            'info_channel' => ['required', 'in:email,phone'],
                            'date' => ['required', 'date'],
                        ],
                        "delay" => 0,
                        "next" => false,
                    ],
            ],
        ],
        'saisie-conservatoire' => [
            true => [
                'sc_1' => [
                        'title' => 'Declarer la nature et le solde des comptes du client sur l\'acte d\'huissier',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sc_2' => [
                        'title' => 'Remplir une fiche de prelement signe par le responsable juridique a adresser a la direction des operations',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sc_3' => [
                        'title' => 'Infomer le client concerne par telephone ou courrier',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sc_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => [
                            true => [
                                'sc_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'sc_4_2' => [
                                        'title' => 'Levee des restriction du compte client',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'sc_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'sc_4_4' => [
                                    'title' => 'QUESTION A DEMANDER',
                                    'rules' => [
                                    ],
                                    "delay" => 0,
                                    "next" => [
                                        true => [
                                            'sc_4_4_1' => [
                                                    'title' => 'Caducite de la saisie en l\'absence de la presentation d\'un titre executoire',
                                                    'rules' => [
                                                    ],
                                                    "delay" => 0,
                                                    "next" => null,
                                                ],
                                            'sc_4_4_2' => [
                                                    'title' => 'Attachement de la main levée de la saisie',
                                                    'rules' => [
                                                    ],
                                                    "delay" => 0,
                                                    "next" => false,
                                                ],
                                        ],
                                        false => [
                                            'sc_4_4_3' => [
                                                    'title' => 'Presentation d\'un titre executoire, d\'un acte de conversion de saisie conservatoire en saisieattribution et d\'une preuve d\'absence d\'opposition',
                                                    'rules' => [
                                                    ],
                                                    "delay" => 0,
                                                    "next" => null,
                                                ],
                                            'sc_4_4_4' => [
                                                    'title' => 'Paiement du creancier par l\'etablissement d\'un cheque',
                                                    'rules' => [
                                                    ],
                                                    "delay" => 0,
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
                        ],
                        "delay" => 0,
                        "next" => false,
                    ],

            ],
        ],
        'saisie-attribution' => [
            true => [
                'sa_1' => [
                        'title' => 'Declarer la nature et le solde des comptes du client sur l\'acte d\'huissier',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sa_2' => [
                        'title' => 'Remplir une fiche de prelement signe par le responsable juridique a adresser a la direction des operations',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sa_3' => [
                        'title' => 'Infomer le client concerne par telephone ou courrier',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => null,
                    ],
                'sa_4' => [
                        'title' => 'Avez vous recu de Main levee ?',
                        'rules' => [
                        ],
                        "delay" => 0,
                        "next" => [
                            true => [
                                'sa_4_1' => [
                                        'title' => 'Attacher le document de la main levee',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'sa_4_2' => [
                                        'title' => 'Levee des restriction du compte client',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => null,
                                    ],
                                'sa_4_3' => [
                                        'title' => 'Informer le client par un courrier',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => false,
                                    ],
                            ],
                            false => [
                                'sa_4_4' => [
                                        'title' => 'QUESTION A DEMANDER',
                                        'rules' => [
                                        ],
                                        "delay" => 0,
                                        "next" => [
                                            true => [
                                                'sa_4_4_1' => [
                                                        'title' => 'Caducite de la saisie en l\'absence de la presentation d\'un titre executoire',
                                                        'rules' => [
                                                        ],
                                                        "delay" => 0,
                                                        "next" => null,
                                                    ],

                                                'sa_4_4_2' => [
                                                        'title' => 'Attachement de la main levée de la saisie',
                                                        'rules' => [
                                                        ],
                                                        "delay" => 0,
                                                        "next" => false,
                                                    ],
                                            ],
                                            false => [
                                                'sa_4_4_3' => [
                                                        'title' => 'Etablir un cheque au nom du creancier ou son mandataire dans la limite du montant saisi',
                                                        'rules' => [
                                                        ],
                                                        "delay" => 0,
                                                        "next" => null,
                                                    ],
                                                'sa_4_4_4' => [
                                                        'title' => 'Informer le client',
                                                        'rules' => [
                                                        ],
                                                        "delay" => 0,
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
                'sa_5' => [
                        'title' => 'Declaration de l\'agent sur l\'exploit d\'huisser',
                        'rules' => [
                        ],
                        "delay" => 0,
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
}
