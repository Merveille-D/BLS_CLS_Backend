<?php

namespace App\Models;

use App\Concerns\Traits\Guarantee\HypothecFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use App\Enums\ConvHypothecState;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Litigation\Litigation;
use App\Models\Recovery\Recovery;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleTask extends Model
{
    use HasFactory, HasUuids, Transferable;

    protected $fillable = [
        'status',
        'code',
        'rank',
        'title',
        'type',
        'taskable_id',
        'taskable_type',
        'created_by',
        'min_deadline',
        'max_deadline',
        'completed_at',
        'completed_by',
        'step_id',
        'extra',
    ];

    protected $casts = [
        'status' => 'boolean',
        'extra' => 'array',
        // 'min_deadline' => 'date',
        // 'max_deadline' => 'date',
    ];

    public function taskable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderByRaw('
            CASE
                WHEN completed_at IS NOT NULL THEN 0
            ELSE 1
            END,
            completed_at ASC,
            CASE
                WHEN max_deadline IS NOT NULL THEN 0
                ELSE 1
            END,
            max_deadline ASC,
            id ASC
        ');
    }

    public function getModuleIdAttribute() : string|null {
        return $this->taskable?->id;
    }
}
