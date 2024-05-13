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
    ];

    protected $casts = [
        'status' => 'boolean',
        // 'min_deadline' => 'date',
        // 'max_deadline' => 'date',
    ];

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
        // 'litigation' => Litigation::class,
        // 'recovery' => Recovery::class
    ];

    public function getFormAttribute() {
        $form = $this->loadFormAttributeBasedOnType($this->taskable);

        return $form;
    }
}
