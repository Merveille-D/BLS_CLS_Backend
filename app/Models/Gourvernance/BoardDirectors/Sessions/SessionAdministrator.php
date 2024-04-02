<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable =  [
        'libelle',
        'reference',
        'session_date',
        'status',
        'pv_file',
        'pv_file_date',
        'agenda_file',
        'agenda_file_date',
        'convocation_file',
        'convocation_file_date',
        'attendance_list_file',
        'attendance_list_file_date',
    ];

    const SESSION_MEETING_STATUS = [
        'pending',
        'post_ag',
        'closed',
    ];

    const SESSION_MEETING_STATUS_VALUES = [
        'pending' => 'En cours',
        'post_ag' => 'Post AG',
        'closed' => 'Terminé',
    ];

    const FILE_FIELD = [
        'pv_file',
        'agenda_file',
        'convocation_file',
        'attendance_list_file',
    ];

    const DATE_FILE_FIELD = [
        'pv_file' => 'pv_file_date',
        'agenda_file' => 'agenda_file_date',
        'convocation_file' => 'convocation_file_date',
        'attendance_list_file' => 'attendance_list_file_date',
    ];

    public function fileUploads()
    {
        return $this->morphMany(GourvernanceDocument::class, 'uploadable');
    }

    public function tasks()
    {
        return $this->hasMany(TaskSessionAdministrator::class);
    }

}
