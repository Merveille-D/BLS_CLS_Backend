<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionActionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'file',
        'session_action_id'
    ];

    public function sessionAction()
    {
        return $this->belongsTo(SessionAction::class);
    }
}
