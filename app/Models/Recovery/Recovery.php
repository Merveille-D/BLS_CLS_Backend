<?php

namespace App\Models\Recovery;

use App\Models\Guarantee\ConvHypothec;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Recovery extends Model
{
    use HasFactory, HasUuids;

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
            return $this->guarantee->current_step;
        }
        return $this->steps()->where('recovery_task.type', 'step')
                    ->orderBy('rank', 'desc')->where('status', true)->first();
    }

    public function getNextStepAttribute()
    {
        if ($this->has_guarantee) {
            return $this->guarantee->next_step;
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
}
