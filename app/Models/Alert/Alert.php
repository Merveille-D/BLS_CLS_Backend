<?php

namespace App\Models\Alert;

use App\Models\Contract\Task;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use App\Observers\Alert\AlertObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([AlertObserver::class])]
class Alert extends Model
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = ['state', 'sent_by', 'sent_to', 'deadline', 'title', 'message', 'type', 'trigger_at', 'priority'];

    const STATUS = [
        'info',
        'warning',
        'urgent',
    ];

    const MODULES = [
        'general_meeting',
        'session_administrator',
        'management_committee',
        'contract',
        'incident',
        'conventionnal_hypothec',
        'legal-watche',
        'litigation',
        'recovery',
    ];

    const ALERT_MODULES = [
        [
            'model' => TaskGeneralMeeting::class,
            'type' => 'general_meeting',
            'title' => 'RAPEL | ASSEMBLEE GENERALE',
        ],
        [
            'model' => TaskSessionAdministrator::class,
            'type' => 'session_administrator',
            'title' => 'RAPEL | CONSEIL D\'ADMINISTRATION',
        ],
        [
            'model' => TaskSessionAdministrator::class,
            'type' => 'management_committee',
            'title' => 'RAPEL | CONSEIL DE DIRECTION',
        ],
        [
            'model' => Task::class,
            'type' => 'contract',
            'title' => 'RAPEL | CONTRAT',
        ],
    ];

    public function alertable()
    {
        return $this->morphTo();
    }
}
