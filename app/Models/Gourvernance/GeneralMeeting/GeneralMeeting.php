<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralMeeting extends Model
{
    use HasFactory;

    protected $fillable = array(
        'libelle',
        'reference',
        'meeting_date',
        'status',
        'pv',
    );


    const GENERAL_MEETING_STATUS = [
        'pending',
        'in_progress',
        'closed',
    ];
}
