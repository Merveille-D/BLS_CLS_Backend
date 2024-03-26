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
    ];

    const SESSION_TASK_TYPE = [
        'checklist',
        'procedures',
        'post_ag'
    ];

    public function general_meeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }
}
