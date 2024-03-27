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
        'checklist',
        'procedures',
        'post_ag'
    ];

    public function session_administrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }
}
