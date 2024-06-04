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
class Tier extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'grade',
        'created_by',
    ];

    const MEETING_TYPE = [
        'general_meeting',
        'session_administrator',
        'management_committee',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
