<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Http\Resources\GeneralMeeting\TaskGeneralMeetingResource;
use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class GeneralMeeting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =  [
        'libelle',
        'meeting_reference',
        'meeting_date',
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
        'reference',
        'created_by',
    ];

    const GENERAL_MEETING_TYPES = [
        'ordinary',
        'extraordinary',
        'mixte',
        'special',
    ];

    const GENERAL_MEETING_STATUS = [
        'pending',
        'post_ag',
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
        'pv' => 'governance.pv',
        'agenda' => 'governance.agenda',
        'convocation' => 'governance.convocation',
        'attendance_list' => 'governance.attendance_list_ag',
        'other' => 'governance.other',
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
        return $this->hasMany(TaskGeneralMeeting::class);
    }

    public function attendanceList()
    {
        return $this->hasMany(AttendanceListGeneralMeeting::class);
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
                    'filename' =>  __(self::FILE_FIELD_VALUE[$type[$field]]),
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

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}

