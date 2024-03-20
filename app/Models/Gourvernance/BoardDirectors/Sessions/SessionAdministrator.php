<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable = array(
        'libelle',
        'reference',
        'session_date',
        'status',
        'pv',
    );

    const SESSION_MEETING_STATUS = [
        'pending',
        'in_progress',
        'closed',
    ];

}
