<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListSessionAdministrator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'grade',
        'lastname',
        'firstname',
        'administrator_id',
        'session_id',
    ];
}
