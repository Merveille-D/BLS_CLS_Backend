<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionPresentAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_administrator_id',
        'administrator_lastname',
        'administrator_firstname'
    ];

    public function sessionAdministrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }
}
