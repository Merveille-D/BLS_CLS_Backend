<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Guarantee\GuaranteeFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuaranteeTask extends Model
{
    use HasFactory, HasUuids, Transferable, GuaranteeFormFieldTrait;

    protected $table = 'module_tasks';

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
        'extra',
    ];

    protected $casts = [
        'status' => 'boolean',
        'extra' => 'array',
    ];

    //step relationship
    public function step()
    {
        return $this->belongsTo(GuaranteeStep::class, 'code', 'code');
    }

    // public function children() {
    //     return $this->hasMany(GuaranteeTask::class, 'parent_id');
    // }

    public function taskable()
    {
        return $this->morphTo();
    }

    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    const MODULES = [
        'conv_hypothec' => ConvHypothec::class,
        'guarantee' => Guarantee::class,
        // 'litigation' => Litigation::class,
        // 'recovery' => Recovery::class
    ];

    public function getFormAttribute()
    {
        // dd($this);
        if ($this->taskable->security == 'personal') {
            $form = $this->loadFormAttributeBasedOnType($this->taskable);
        } else {
            $form = $this->loadFormAttributeBasedTask($this);
        }

        return $form;
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
}
