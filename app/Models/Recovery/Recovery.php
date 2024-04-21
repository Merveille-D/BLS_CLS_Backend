<?php

namespace App\Models\Recovery;

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
        'payement_status',
        'is_seized',
        'is_entrusted'
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
        return $this->steps()->orderBy('rank', 'desc')->where('status', true)->first();
    }

    public function getNextStepAttribute()
    {
        return $this->steps()->orderBy('rank')->where('status', false)->first();
    }

    public function documents() : MorphMany
    {
        return $this->morphMany(RecoveryDocument::class, 'documentable');
    }
}
