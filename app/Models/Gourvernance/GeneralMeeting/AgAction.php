<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'is_file',
        'closing_date',
        'general_meeting_id',
        'ag_type_id',
        'step_ag_day',
    ];

    CONST ACTIONS = [
        1 => [
            [
                'title' => 'Fixer Lieu AG',
                'closing_date'=> null ,
                'is_file' => true ,
                'files' => [
                    'file_1',
                    'file_2',
                    'file_3',
                ],
            ],
            [
                'title' => 'Avis de convocation',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => "Projet d'ordre du jour",
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Projet de résolutions',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Rapport Commissaires aux comptes',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => "Rapport Conseil d'administration",
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Insérer Annonce dans un journal',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Envoyer des lettres aux actionnaires & CC',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Tenir documents AG à disposition des actionnaires',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
        ],

        2 => [

            'checklist' => [
                [
                    'title' => 'Vérifier salle et Sonorisation',
                ],
                [
                    'title' => "Enregistrer actionnaires à l'arrivée dans le système IT",
                ],
                [
                    'title' => 'Installer PCA Administrateurs, CC & Invités',
                ],
                [
                    'title' => 'Imprimer liste de présence',
                ],
                [
                    'title' => 'Vérifier le Quorum',
                ],
                [
                    'title' => 'Remettre liste de présence au PCA',
                ],
            ],

            'procedures' => [
                [
                    'title' => 'PCA ouvre la séance, préside et confirme le quorum',
                ],
                [
                    'title' => 'Désignation Bureau (Scrutateurs + Sécrétaire)',
                ],
                [
                    'title' => 'PCA confirme présence CC et documents légaux',
                ],
                [
                    'title' => "PCA annonce l'ordre du jour et lit le Rapport de gestion",
                ],
                [
                    'title' => 'PCA invite le CC à présenter leurs rapports',
                ],
                [
                    'title' => 'PCA ouvre débat suivi du vote des résolutions',
                ],
            ],
        ],

        3 => [

            [
                'title' => 'Rédiger et faire signer PV',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Transmettre au Notaire pour formalités',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Recevoir du Notaire le PV enregistré et classer',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Créer Table des actions',
                'closing_date'=> null ,
                'is_file' => false ,
            ],
            [
                'title' => 'Suivre mise en oeuvre des actions',
                'closing_date'=> null ,
                'is_file' => false ,
            ],

        ],
    ];

    public function actionsTypeFile()
    {
        return $this->hasMany(AgActionTypeFile::class);
    }

    public function actionsFile()
    {
        return $this->hasMany(AgActionFile::class);
    }

    public function generalMeeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }

    public function agType()
    {
        return $this->belongsTo(AgType::class);
    }

}
