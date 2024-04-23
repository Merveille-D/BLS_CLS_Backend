<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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

    public function getTitleAttribute() {
        $response = Http::get(env('APP_URL'). '/' . $this->module . '/' . $this->module_id );
        $title = $response['title'];
        return $title;
    }
}
