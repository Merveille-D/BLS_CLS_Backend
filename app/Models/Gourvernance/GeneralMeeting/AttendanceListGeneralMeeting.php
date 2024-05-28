<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListGeneralMeeting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'shareholder_id',
        'general_meeting_id',
        'representant_id',
    ];
}
