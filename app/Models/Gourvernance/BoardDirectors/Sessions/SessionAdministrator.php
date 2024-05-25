<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAdministrator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =  [
        'libelle',
        'reference',
        'session_date',
        'type',
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

    const SESSION_MEETING_TYPES = [
        'first_quarter',
        'second_quarter',
        'third_quarter',
        'fourth_quarter',
    ];

    const SESSION_MEETING_STATUS = [
        'pending',
        'post_ca',
        'closed',
    ];

    const FILE_FIELD = [
        'pv_file',
        'agenda_file',
        'convocation_file',
        'attendance_list_file',
    ];

    const TYPE_FILE_FIELD = [
        'pv',
        'agenda',
        'convocation',
        'attendance_list',
        'other'
    ];

    const TYPE_FILE_FIELD_VALUE = [
        'pv' => 'pv_file',
        'agenda' => 'agenda_file',
        'convocation' => 'convocation_file',
        'attendance_list' => 'attendance_list_file',
        'other' => 'other_file',
    ];

    const FILE_FIELD_VALUE = [
        'pv' => 'Procès verbal',
        'agenda' => 'Ordre du jour',
        'convocation' => 'Convocation',
        'attendance_list' => 'Liste de présence des actionnaires',
    ];

    const DATE_FILE_FIELD = [
        'pv_file' => 'pv_file_date',
        'agenda_file' => 'agenda_file_date',
        'convocation_file' => 'convocation_file_date',
        'attendance_list_file' => 'attendance_list_file_date',
    ];

    const SESSION_MEETING_TYPES_VALUES = [
        'first_quarter' => '1er trimestre',
        'second_quarter' => '2ème trimestre',
        'third_quarter' => '3ème trimestre',
        'fourth_quarter' => '4ème trimestre',
    ];

    public function fileUploads()
    {
        return $this->morphMany(GourvernanceDocument::class, 'uploadable');
    }

    public function attendanceList()
    {
        return $this->hasMany(AttendanceListSessionAdministrator::class, 'session_id');
    }

    public function tasks()
    {
        return $this->hasMany(TaskSessionAdministrator::class);
    }

    public function getFilesAttribute()
    {
        $files = [];

        $type = array_flip(self::TYPE_FILE_FIELD_VALUE);

        $directFiles = [
            'pv_file',
            'convocation_file',
            'agenda_file',
            'attendance_list_file'
        ];

        foreach ($directFiles as $field) {
            if (!empty($this->$field)) {
                $files[] = [
                    'filename' => self::FILE_FIELD_VALUE[$type[$field]],
                    'file_url' => $this->$field,
                    'type' => $type[$field],
                ];
            }
        }

        foreach ($this->fileUploads as $fileUpload) {
            $files[] = [
                'filename' => $fileUpload->name ?? null,
                'file_url' => $fileUpload->file,
                'type' => 'other',
            ];
        }
        return $files;
    }

    public function getNextTaskAttribute()
    {
        $task = $this->tasks()->whereNotNull('deadline')->orderBy('deadline', 'asc')->where('status', false)->first();
        return $task;
    }

}
