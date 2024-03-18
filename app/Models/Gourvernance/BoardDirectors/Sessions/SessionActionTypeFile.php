<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionActionTypeFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'session_action_id',
    ];

    public function actions()
    {
        return $this->belongsTo(SessionAction::class);
    }
}
