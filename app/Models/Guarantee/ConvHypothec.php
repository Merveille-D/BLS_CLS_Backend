<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Guarantee\HypothecFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use App\Observers\ConvHypothecObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([ConvHypothecObserver::class])]
class ConvHypothec extends Model
{
    use Alertable, HasFactory, HasUuids, HypothecFormFieldTrait, Transferable;

    /**
     * @property int $id
     * @property string $name
     * @property bool $is_verified
     * @property bool $is_approved
     * @property string $date_sell
     * @property string $date_signification
     */
    protected $fillable = [
        'name',
        'is_verified',
        'contract_file',
        'state',
        'step',
        'reference',
        'contract_id',
        'forwarded_date',
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
        'summation_date',
        'is_archived',
        'has_recovery',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'is_subscribed' => 'boolean',
        'is_significated' => 'boolean',
        'is_publied' => 'boolean',
        'is_archived' => 'boolean',
        'has_recovery' => 'boolean',
    ];

    public function tasks()
    {
        return $this->morphMany(HypothecTask::class, 'taskable');
    }

    public function getNextTaskAttribute()
    {
        return $this->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderBy('max_deadline')
            ->orderBy('rank')
            ->where('status', false)->first();
    }

    public function getCurrentTaskAttribute()
    {
        return $this->tasks()
            ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
            ->orderByDesc('max_deadline')
            ->orderByDesc('rank')
            ->where('status', true)
            ->first();
    }

    /**
     * documents
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(GuaranteeDocument::class, 'documentable');
    }

    public function steps()
    {
        return $this->belongsToMany(ConvHypothecStep::class, 'hypothec_step', 'hypothec_id', 'step_id')
            ->select('conv_hypothec_steps.id', 'code', 'rank', 'min_delay', 'max_delay', 'conv_hypothec_steps.name', 'conv_hypothec_steps.type', 'hypothec_step.max_deadline', 'hypothec_step.min_deadline', 'hypothec_step.created_at')
            ->selectRaw('case when hypothec_step.status = 1 then true else false end as status')
            ->withTimestamps();
    }

    public function getCurrentStepAttribute()
    {
        return $this->steps()->orderBy('rank', 'desc')->where('status', true)->first();
    }

    public function getNextStepAttribute()
    {
        return $this->steps()->orderBy('rank')->where('status', false)->first();
    }

    public function getValidationAttribute()
    {
        $step = $this->next_task;

        if (! $step) {
            return [];
        }
        $form = $this->getCustomFormFields($step->code);

        return [
            'method' => 'POST',
            'action' => config('app.url') . '/api/conventionnal_hypothec/update/' . $this->id,
            'form' => $form,
        ];
    }
}
