<?php

namespace App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListManagementCommittee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'grade',
        'lastname',
        'firstname',
        'director_id',
        'session_id',
    ];
}
