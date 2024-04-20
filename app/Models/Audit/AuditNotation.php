<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditNotation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'module_id',
        'module',
    ];

    const STATUS =[
        'evaluated',
        'verified',
        'validated',
    ];

    public function performances()
    {
        return $this->hasMany(AuditNotationPerformance::class);
    }

    public function getIndicatorsAttribute() {

        $indicators = [];

        foreach ($this->performances as $audit_performance) {
            $indicators[] = [
                'audit_performance_indicator' => $audit_performance->auditPerformanceIndicator,
                'note' => $audit_performance->note,
            ];
        }
        return $indicators;
    }
}
