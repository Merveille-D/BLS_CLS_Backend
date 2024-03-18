<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionActionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'session_action_id',
        'session_action_type_file_id',
    ];

    public function sessionAction()
    {
        return $this->belongsTo(SessionAction::class);
    }

    public function sessionActionTypeFile()
    {
        return $this->belongsTo(SessionActionTypeFile::class);
    }
}
