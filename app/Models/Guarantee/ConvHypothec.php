<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Alert\Alertable;
use App\Models\Alert\Alert;
use App\Observers\ConvHypothecObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([ConvHypothecObserver::class])]
class ConvHypothec extends Model
{
    use HasFactory, Alertable, HasUuids;

    /**
     * @property int $id
     * @property string $name
     * @property bool $is_verified
     * @property bool $is_approved
     * @property string $date_sell
     * @property string $date_signification
     */
    protected $fillable = array(
        'name',
        'is_verified',
        'contract_file',
        'state',
        'step',
        'reference',
        'contract_id',
        'registration_date',
        'registering_date',
        'is_subscribed',
        'is_approved',
        'date_signification',
        'type_actor',
        'is_significated',
        'date_sell',
        'date_deposit_specification',
        'is_publied',
        'sell_price_estate',
    );

    /**
     * documents
     *
     * @return MorphMany
     */
    public function documents() : MorphMany
    {
        return $this->morphMany(GuaranteeDocument::class, 'documentable');
    }

    public function steps()
    {
        return $this->belongsToMany(ConvHypothecStep::class, 'hypothec_step', 'hypothec_id', 'step_id');
    }

    function getCurrentStepAttribute() {
        return $this->steps()->orderBy('rank', 'desc')->first();
    }

    public function getNextStepAttribute()
    {
        $currentStep = $this->current_step;
        $nextStep = ConvHypothecStep::where('rank', $currentStep->rank+1)->orderBy('rank')->first();
        return $nextStep;
    }

    public function getStepsAttribute() {
        $steps = ConvHypothecStep::select('conv_hypothec_steps.id', 'code', 'conv_hypothec_steps.name', 'conv_hypothec_steps.type',
                 'conv_hypothecs.id as hypothec_id', 'hypothec_step.created_at')
                ->leftJoin('hypothec_step', 'conv_hypothec_steps.id', '=', 'hypothec_step.step_id')
                ->leftJoin('conv_hypothecs', function ($join){
                    $join->on('conv_hypothecs.id', '=', 'hypothec_step.hypothec_id')
                        ->where('hypothec_step.hypothec_id', $this->id);
                })
                ->when($this->step == 'formalization', function($qry) {
                    $qry->where('conv_hypothec_steps.type', 'formalization');
                })
                ->orderBy('conv_hypothec_steps.id')
                ->get();
        return $steps;
    }

}
