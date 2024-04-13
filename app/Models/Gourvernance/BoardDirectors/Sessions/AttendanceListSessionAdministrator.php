<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListSessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'lastname',
        'firstname',
        'ca_administrator_id',
        'session_administrator_id',
    ];
}