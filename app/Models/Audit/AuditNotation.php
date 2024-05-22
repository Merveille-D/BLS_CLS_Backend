<?php

namespace App\Models\Audit;

use App\Models\Contract\Contract;
use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\Guarantee;
use App\Models\Incident\Incident;
use App\Models\Litigation\Litigation;
use App\Models\Recovery\Recovery;
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
        'archived',
    ];

    const MODELS_MODULES = [
        'contracts'=> Contract::class,
        'conventionnal_hypothec'=> ConvHypothec::class,
        'litigation' => Litigation::class,
        'incidents' => Incident::class,
        'recovery' => Recovery::class,
        'general_meeting' => GeneralMeeting::class,
        'session_administrators' => SessionAdministrator::class,
        'management_committees' => ManagementCommittee::class,
        'guarantees_security_movable' => Guarantee::class,
        'guarantees_security_personal' => Guarantee::class,
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

        $securtiy = $this->module == 'guarantees_security_movable' ? 'movable' : 'personal';

        $response = $model::find($this->module_id)->where('security', $securtiy)->first();

        return $response->libelle ?? $response->name ?? $response->title;
    }
}
