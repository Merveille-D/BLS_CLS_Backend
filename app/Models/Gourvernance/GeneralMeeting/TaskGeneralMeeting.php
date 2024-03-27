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
        'general_meeting_id',
    ];

    const MEETING_TASK_TYPE = [
        'checklist',
        'procedures',
        'post_ag'
    ];

    public function general_meeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }
}
