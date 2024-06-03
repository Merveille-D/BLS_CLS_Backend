<?php

namespace App\Models\Gourvernance;

use App\Models\Gourvernance\BoardDirectors\Sessions\AttendanceListSessionAdministrator;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\AttendanceListManagementCommittee;
use App\Models\Gourvernance\GeneralMeeting\AttendanceListGeneralMeeting;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class Representant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'grade',
        'type',
        'created_by',
    ];

    const MEETING_TYPE = [
        'general_meeting',
        'session_administrator',
        'management_committee',
    ];

    const MEETING_MODEL = [
        'general_meeting' => AttendanceListGeneralMeeting::class,
        'session_administrator' => AttendanceListSessionAdministrator::class,
        'management_committee' => AttendanceListManagementCommittee::class,
    ];

    const MEETING_TYPE_ID = [
        'general_meeting' => 'general_meeting_id',
        'session_administrator' => 'session_id',
        'management_committee' => 'session_id',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
