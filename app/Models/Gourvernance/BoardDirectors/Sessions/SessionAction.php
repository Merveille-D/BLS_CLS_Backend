<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'is_file',
        'closing_date',
        'session_administrator_id',
        'session_type_id'
    ];

    public function sessionAdministrator()
    {
        return $this->belongsTo(SessionAdministrator::class);
    }

    public function sessionType()
    {
        return $this->belongsTo(SessionType::class);
    }
}
