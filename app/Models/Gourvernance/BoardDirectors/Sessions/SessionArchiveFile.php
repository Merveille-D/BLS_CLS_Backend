<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionArchiveFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'session_administrator_id'
    ];

    public function sessionAdministrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }

}
