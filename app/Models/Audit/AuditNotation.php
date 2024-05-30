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
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
#[ScopedBy([CountryScope::class])]
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

    protected $appends = ['indicators'];

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

    public function getLastAuditNotationAttribute(){

        $transfer_notation = self::where('parent_id', $this->id)
        ->whereNotNull('note')
        ->orderBy('created_at', 'desc')
        ->first();

        return ($transfer_notation) ? $transfer_notation : self::find($this->id);
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

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
