<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGeneralMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'deadline',
        'type',
        'status',
        'responsible',
        'supervisor',
    ];

    const MEETING_TASK_TYPE = [
        'checklist',
        'procedures',
        'post_ag'
    ];

    public function session_administrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }
}
