<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPerformanceIndicator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'module',
        'type',
        'note',
        'description',
    ];

    const MODULES = [
        'contracts',
        'conventionnal_hypothec',
        'litigation',
        'incidents',
        'recovery',
        'guarantees_security_personal',
        'guarantees_security_movable',
        'general_meeting',
        'session_administrators',
        'management_committees',
    ];

    const TYPES = [
        'quantitative',
        'qualitative',
    ];

    public function auditNotations()
    {
        return $this->hasMany(AuditNotation::class);
    }


}
