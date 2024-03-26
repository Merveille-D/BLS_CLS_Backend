<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use App\Models\FileUpload;
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
        'alert_msg_pending',
        'alert_msg_in_progress',
        'alert_msg_closed',
    ];

    const SESSION_MEETING_STATUS = [
        'pending',
        'in_progress',
        'closed',
    ];

    const SESSION_MEETING_STATUS_VALUES = [
        'pending' => 'En attente',
        'in_progress' => 'En cours',
        'closed' => 'Terminé',
    ];

    const DATE_FILE_FIELD = [
        'pv_file' => 'pv_file_date',
        'agenda_file' => 'agenda_file_date',
        'convocation_file' => 'convocation_file_date',

    ];

    public function fileUploads()
    {
        return $this->morphMany(FileUpload::class, 'uploadable');
    }

}
