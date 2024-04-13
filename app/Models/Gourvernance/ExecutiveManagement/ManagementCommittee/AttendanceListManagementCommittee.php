<?php

namespace App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceListManagementCommittee extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'lastname',
        'firstname',
        'director_id',
        'management_committee_id',
    ];
}
