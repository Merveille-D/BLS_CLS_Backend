<?php

namespace App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManagementCommittee extends Model
{
    use HasFactory;

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
        'management_committee_id',
    ];

    const SESSION_TASK_TYPE = [
        'pre_cd',
        'checklist',
        'procedure',
        'post_cd'
    ];

    public function management_committee()
    {
        return $this->belongsTo(ManagementCommittee::class);
    }

    CONST TASKS = [
        'pre_cd' => [
            [
                'libelle' => "Préparation de la convocation, ODJ et documents à étudier",
                'days' => -5,
            ],
            [
                'libelle' => "Transmission de la convocation aux membres du CODIR",
                'days' => -4,
            ],
            [
                'libelle' => "Tenue CA",
                'days' => 0,
            ],
            [
                'libelle' => "Rédaction du PV et signature",
                'days' => 1,
            ],
            [
                'libelle' => "Classement du PV",
                'days' => 2,
            ],

        ],
        'procedure' => [
        ],
        'checklist' => [
        ],
    ];


}
