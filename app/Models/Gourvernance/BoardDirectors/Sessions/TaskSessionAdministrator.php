<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'deadline',
        'type',
        'status',
        'responsible',
        'supervisor',
        'session_administrator_id',
    ];

    const SESSION_TASK_TYPE = [
        'pre_ca',
        'checklist',
        'procedure',
        'post_ca'
    ];

    public function session_administrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }

    CONST TASKS = [
        'pre_ca' => [
            [
                'libelle' => "Préparation de la convocation, ODJ et documents à étudier",
                'days' => -45,
            ],
            [
                'libelle' => "Transmission de la convocation aux administrateurs",
                'days' => -15,
            ],
            [
                'libelle' => "Tenue CA",
                'days' => 0,
            ],
            [
                'libelle' => "Rédaction du PV et signature",
                'days' => 10,
            ],
            [
                'libelle' => "Transmission du PV au Notaire",
                'days' => 15,
            ],
            [
                'libelle' => "Reception PV enrégistré et classement",
                'days' => 25,
            ],

        ],
        'procedure' => [
            ['libelle' => "PCA ouvre la séance, préside et confirme quorum"],
            ['libelle' => "PCA annonce ordre du jour et lit Rapport de Gestion"],
        ],
        'checklist' => [
            ['libelle' => "Vérifier salle et sonorisation"],
            ['libelle' => "Installer PCA, Administrateurs, CC et invités"],
            ['libelle' => "Imprimer Liste de présence"],
            ['libelle' => "Vérifier Quorum"],
            ['libelle' => "Remettre Liste de présence au PCA"],
        ],
    ];


}
