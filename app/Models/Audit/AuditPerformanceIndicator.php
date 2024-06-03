<?php

namespace App\Models\Audit;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class AuditPerformanceIndicator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'module',
        'type',
        'note',
        'description',
        'created_by',
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

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }


}
