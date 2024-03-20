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
        'type',
        'session_step_id',
    );


    const SESSION_MEETING_TYPES = [
        'ordinary',
        'extraordinary',
        'annual',
    ];

    public function step()
    {
        return $this->belongsTo(SessionStep::class, 'session_step_id');
    }

    public function files()
    {
        return $this->hasMany(SessionStepFile::class);
    }

}
