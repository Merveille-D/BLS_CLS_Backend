<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionPresentAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_administrator_id',
        'ca_administrator_id',
    ];

    public function sessionAdministrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }
}
