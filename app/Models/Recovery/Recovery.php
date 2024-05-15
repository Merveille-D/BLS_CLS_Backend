<?php

namespace App\Models\Recovery;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Recovery\RecoveryFormFieldTrait;
use App\Models\Guarantee\ConvHypothec;
use App\Models\ModuleTask;
use App\Observers\Recovery\RecoveryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([RecoveryObserver::class])]
class Recovery extends Model
{
    use HasFactory, HasUuids, Alertable, RecoveryFormFieldTrait;

    protected $fillable = [
        'name',
        'reference',
        'status',
        'type',
        'has_guarantee',
        'guarantee_id',
        'payement_status',
        'is_seized',
        'is_entrusted',
        'is_archived'
    ];

    protected $casts = [
        'has_guarantee' => 'boolean',
        'is_seized' => 'boolean',
        'is_entrusted' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function tasks()
    {
        return $this->morphMany(ModuleTask::class, 'taskable');
    }

    public function steps()
    {
        return $this->belongsToMany(RecoveryStep::class, 'recovery_task', 'recovery_id', 'step_id')
                ->select('recovery_steps.id', 'code', 'rank', 'recovery_steps.name', 'recovery_task.type',
                 'recovery_task.deadline', 'recovery_task.created_at')
                ->selectRaw('case when recovery_task.status = 1 then true else false end as status')
                ->withTimestamps();
    }

    function getCurrentStepAttribute() {
        if ($this->has_guarantee) {
            return $this->guarantee->current_step ?? null;
        }
        return $this->steps()->where('recovery_task.type', 'step')
                    ->orderBy('rank', 'desc')->where('status', true)->first();
    }

    public function getNextStepAttribute()
    {
        if ($this->has_guarantee) {
            return $this->guarantee->next_step ?? null;
        }
        return $this->steps()->where('recovery_task.type', 'step')
                    ->orderBy('rank')->where('status', false)->first();
    }

    public function documents() : MorphMany
    {
        return $this->morphMany(RecoveryDocument::class, 'documentable');
    }

    /**
     * important to note that this section is provisional before microservices
     *
     * Get the guarantee that owns the Recovery
     */
    public function guarantee()
    {
        return $this->belongsTo(ConvHypothec::class, 'guarantee_id');
    }

    public function getValidationAttribute()
    {
        $step = $this->next_step;

        if ($step) {
            $form = $this->getCustomFormFields($step->code);

            return [
                'method' => 'POST',
                'action' => env('APP_URL') . '/api/recovery/update/' . $this->id,
                'form' => $form,
            ];
        }
        return null;
    }
}
