<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListGeneralMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'lastname',
        'firstname',
        'shareholder_id',
        'general_meeting_id',
    ];
}
