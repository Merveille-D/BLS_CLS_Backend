<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Concerns\Traits\Alert\Alertable;
use App\Observers\TaskGeneralMeetingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy([TaskGeneralMeetingObserver::class])]
class TaskGeneralMeeting extends Model
{
    use HasFactory, HasUuids, Alertable;

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'libelle',
        'deadline',
        'type',
        'status',
        'responsible',
        'supervisor',
        'general_meeting_id',
    ];

    const MEETING_TASK_TYPE = [
        'pre_ag',
        'checklist',
        'procedure',
        'post_ag'
    ];

    public function general_meeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }

    CONST TASKS = [
        'pre_ag' => [
            [
                'libelle' => "Premier rappel des écheances du CA et de l'AG aux chefs departements.",
                'days' => -105,
            ],
            [
                'libelle' => "Second rappel aux chefs departements",
                'days' => -90,
            ],
            [
                'libelle' => "Appreter les dossiers de : CA (ODJ, rapports DG, rapports comités CA...) - AG (ODJ, rapports CA, rapports CC, projet de résolutions)",
                'days' => -65,
            ],
            [
                'libelle' => "Convoquer le CA",
                'days' => -60,
            ],
            [
                'libelle' => "Réception des rapports des Commissaires aux Comptes (CC)",
                'days' => -55,
            ],
            [
                'libelle' => "Envoyer les dossiers du CA (et dossiers de l'AG à valider) aux administrateurs",
                'days' => -50,
            ],
            [
                'libelle' => "Tenue du premier CA de l'année",
                'days' => -45,
            ],
            [
                'libelle' => "Premiere publication dans la presse de l'avis de convocation",
                'days' => -30,
            ],
            [
                'libelle' => "Deuxième publication dans la presse de l'avis de convocation",
                'days' => -15
            ],
            [
                'libelle' => "Tenue de l'AG",
                'days' => 0
            ],
            [
                'libelle' => "Rédaction du Procèsverbal de l'AG et signature",
                'days' => 15
            ],
            [
                'libelle' => "Transmission du PV de l'AG au Notaire pour les formalités légales",
                'days' => 20
            ],
            [
                'libelle' => "Réception du PV enrégistré et classement",
                'days' => 30
            ],
        ],
        'procedure' => [
            ['libelle' => "PCA ouvre la séance, préside et confirme quorum"],
            ['libelle' => "PCA: Désignation Bureau (Scrutateurs + Secrétaire)"],
            ['libelle' => "PCA confirme présence CC et documents légaux"],
            ['libelle' => "PCA annonce ordre du jour et lit Rapport de Gestion"],
            ['libelle' => "PCA invite CC à présenter leurs Rapports"],
            ['libelle' => "PCA ouvre débats suivis du vote des résolutions"],
        ],
        'checklist' => [
            ['libelle' => "Vérifier salle et sonorisation"],
            ['libelle' => "Enregistrer actionnaires à l'arrivée dans le système IT"],
            ['libelle' => "Installer PCA, Administrateurs, CAC et invités"],
            ['libelle' => "Imprimer Liste de présence"],
            ['libelle' => "Vérifier Quorum"],
            ['libelle' => "Remettre Liste de présence au PCA"],
        ],
    ];
}
