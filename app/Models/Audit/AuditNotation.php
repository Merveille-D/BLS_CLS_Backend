<?php

namespace App\Models\Audit;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
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
    use HasFactory, HasUuids, Alertable, Transferable;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'module_id',
        'module',
        'date',
        'created_by',
        'parent_id',
    ];

    protected $appends = ['indicators', 'steps'];

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

    public function auditPeriod()
    {
        return $this->belongsTo(AuditPeriod::class);
    }

    public function getStepsAttribute() {

        $childrens = self::where('parent_id', $this->id)->get()->makeHidden('performances','steps');
        $parent = self::find($this->id)->makeHidden('performances','steps');

        $steps = array_merge($parent, $childrens);

        return $steps;
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

        $response = $model::query()
                      ->when($this->module == 'guarantees_security_movable', function($query) {
                          return $query->where('security', 'movable');
                      })
                      ->when($this->module == 'guarantees_security_personal', function($query) {
                          return $query->where('security', 'personal');
                      })
                      ->where('id', $this->module_id)
                      ->first();

        return $response->libelle ?? $response->name ?? $response->title;
    }
}
