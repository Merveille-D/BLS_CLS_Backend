<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\TaskSessionAdministratorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
#[ObservedBy([TaskSessionAdministratorObserver::class])]
class TaskSessionAdministrator extends Model
{
    use Alertable, HasFactory, HasUuids, Transferable;

    const SESSION_TASK_TYPE = [
        'pre_ca',
        'checklist',
        'procedure',
        'post_ca',
    ];

    const TASKS = [
        'pre_ca' => [
            [
                'code' => 'pre_ca.lib.1',
                'days' => -45,
            ],
            [
                'code' => 'pre_ca.lib.2',
                'days' => -15,
            ],
            [
                'code' => 'pre_ca.lib.3',
                'days' => 0,
            ],
            [
                'code' => 'pre_ca.lib.4',
                'days' => 10,
            ],
            [
                'code' => 'pre_ca.lib.5',
                'days' => 15,
            ],
            [
                'code' => 'pre_ca.lib.6',
                'days' => 25,
            ],

        ],
        'procedure' => [
            ['code' => 'procedure.ca.lib.1'],
            ['code' => 'procedure.ca.lib.2'],
        ],
        'checklist' => [
            ['code' => 'checklist.ca.lib.1'],
            ['code' => 'checklist.ca.lib.2'],
            ['code' => 'checklist.ca.lib.3'],
            ['code' => 'checklist.ca.lib.4'],
            ['code' => 'checklist.ca.lib.5'],
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
        'status',
        'code',
        'responsible',
        'supervisor',
        'session_administrator_id',
        'completed_by',
        'created_by',
    ];

    public function sessionAdministrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }

    public function getFolderAttribute()
    {
        return $this->sessionAdministrator->code;
    }

    public function getValidationAttribute()
    {

        return [
            'method' => 'PUT',
            'action' => config('app.url') . '/api/task_session_administrators/' . $this->id,
        ];
    }

    public function getModuleIdAttribute(): ?string
    {
        return $this->sessionAdministrator?->id;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
