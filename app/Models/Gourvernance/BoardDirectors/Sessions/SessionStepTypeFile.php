<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionStepTypeFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'session_step_id',
    ];

    public function step()
    {
        return $this->belongsTo(SessionStep::class);
    }

    public function files()
    {
        return $this->hasMany(SessionStepFile::class);
    }

}
