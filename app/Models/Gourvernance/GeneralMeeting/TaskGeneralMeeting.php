<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\TaskGeneralMeetingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
#[ObservedBy([TaskGeneralMeetingObserver::class])]
class TaskGeneralMeeting extends Model
{
    use Alertable, HasFactory, HasUuids, Transferable;

    const MEETING_TASK_TYPE = [
        'pre_ag',
        'checklist',
        'procedure',
        'post_ag',
    ];

    const TASKS = [
        'pre_ag' => [
            [
                'code' => 'pre_ag.lib.1',
                'days' => -105,
            ],
            [
                'code' => 'pre_ag.lib.2',
                'days' => -90,
            ],
            [
                'code' => 'pre_ag.lib.3',
                'days' => -65,
            ],
            [
                'code' => 'pre_ag.lib.4',
                'days' => -60,
            ],
            [
                'code' => 'pre_ag.lib.5',
                'days' => -55,
            ],
            [
                'code' => 'pre_ag.lib.6',
                'days' => -50,
            ],
            [
                'code' => 'pre_ag.lib.7',
                'days' => -45,
            ],
            [
                'code' => 'pre_ag.lib.8',
                'days' => -30,
            ],
            [
                'code' => 'pre_ag.lib.9',
                'days' => -15,
            ],
            [
                'code' => 'pre_ag.lib.10',
                'days' => 0,
            ],
            [
                'code' => 'pre_ag.lib.11',
                'days' => 15,
            ],
            [
                'code' => 'pre_ag.lib.12',
                'days' => 20,
            ],
            [
                'code' => 'pre_ag.lib.13',
                'days' => 30,
            ],
        ],
        'procedure' => [
            ['code' => 'procedure.ag.lib.1'],
            ['code' => 'procedure.ag.lib.2'],
            ['code' => 'procedure.ag.lib.3'],
            ['code' => 'procedure.ag.lib.4'],
            ['code' => 'procedure.ag.lib.5'],
            ['code' => 'procedure.ag.lib.6'],
        ],
        'checklist' => [
            ['code' => 'checklist.ag.lib.1'],
            ['code' => 'checklist.ag.lib.2'],
            ['code' => 'checklist.ag.lib.3'],
            ['code' => 'checklist.ag.lib.4'],
            ['code' => 'checklist.ag.lib.5'],
            ['code' => 'checklist.ag.lib.6'],
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
        'responsible',
        'code',
        'supervisor',
        'general_meeting_id',
        'completed_by',
        'created_by',
    ];

    public function generalMeeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }

    public function getFolderAttribute()
    {
        return $this->generalMeeting->libelle;
    }

    public function getValidationAttribute()
    {

        return [
            'method' => 'PUT',
            'action' => config('app.url') . '/api/task_general_meetings/' . $this->id,
        ];
    }

    public function getModuleIdAttribute(): ?string
    {
        return $this->generalMeeting?->id;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
