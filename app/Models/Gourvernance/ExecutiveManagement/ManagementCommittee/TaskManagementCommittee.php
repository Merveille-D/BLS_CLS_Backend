<?php

namespace App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\TaskManagementCommitteeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
#[ObservedBy([TaskManagementCommitteeObserver::class])]
class TaskManagementCommittee extends Model
{
    use Alertable, HasFactory, HasUuids, Transferable;

    const SESSION_TASK_TYPE = [
        'pre_cd',
        'checklist',
        'procedure',
        'post_cd',
    ];

    const TASKS = [
        'pre_cd' => [
            [
                'code' => 'pre_cd.lib.1',
                'days' => -5,
            ],
            [
                'code' => 'pre_cd.lib.2',
                'days' => -4,
            ],
            [
                'code' => 'pre_cd.lib.3',
                'days' => 0,
            ],
            [
                'code' => 'pre_cd.lib.4',
                'days' => 1,
            ],
            [
                'code' => 'pre_cd.lib.5',
                'days' => 2,
            ],

        ],
        'procedure' => [
        ],
        'checklist' => [
        ],
    ];

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
        'code',
        'status',
        'responsible',
        'supervisor',
        'management_committee_id',
        'completed_by',
        'created_by',
    ];

    public function managementCommittee()
    {
        return $this->belongsTo(ManagementCommittee::class);
    }

    public function getFolderAttribute()
    {
        return $this->managementCommittee->code;
    }

    public function getValidationAttribute()
    {

        return [
            'method' => 'PUT',
            'action' => config('app.url') . '/api/task_management_committees/' . $this->id,
        ];
    }

    public function getModuleIdAttribute(): ?string
    {
        return $this->managementCommittee?->id;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
