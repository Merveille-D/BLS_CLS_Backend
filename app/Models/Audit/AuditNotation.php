<?php

namespace App\Models\Audit;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Contract\Contract;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Incident\Incident;
use App\Models\Litigation\Litigation;
use App\Models\Recovery\Recovery;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class AuditNotation extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'module_id',
        'module',
        'created_by',
        'parent_id',
    ];

    const STATUS =[
        'evaluated',
        'verified',
        'validated',
        'archived',
    ];

    const MODELS_MODULES = [
        'contracts'=> Contract::class,
        'conventionnal_hypothec'=> ConvHypothec::class,
        'litigation' => Litigation::class,
        'incidents' => Incident::class,
        'recovery' => Recovery::class,
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

        $model = self::MODELS_MODULES[$this->module];
        $response = $model::find($this->module_id);
        return $response->title;
    }
}
