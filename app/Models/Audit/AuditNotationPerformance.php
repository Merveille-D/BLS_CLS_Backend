<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditNotationPerformance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'audit_notation_id',
        'audit_performance_indicator_id',
        'note',
    ];

    public function auditNotation()
    {
        return $this->belongsTo(AuditNotation::class);
    }

    public function auditPerformanceIndicator()
    {
        return $this->belongsTo(AuditPerformanceIndicator::class, 'audit_performance_indicator_id');
    }
}
