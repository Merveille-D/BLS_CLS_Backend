<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'session_date',
        'type'
    ];

    const SESSION_MEETING_TYPES = [
        'ordinary',
        'extraordinary',
        'annual',
    ];

    public function actions()
    {
        return $this->hasMany(SessionAction::class);
    }

    public function archives()
    {
        return $this->hasMany(SessionArchiveFile::class);
    }

    public function administrators()
    {
        return $this->hasMany(SessionPresentAdministrator::class);
    }
}
