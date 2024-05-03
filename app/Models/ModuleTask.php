<?php

namespace App\Models;

use App\Concerns\Traits\Transfer\Transferable;
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    const MODULES = [
        'conv_hypothec' => ConvHypothec::class,
        'litigation' => Litigation::class,
        'recovery' => Recovery::class
    ];

    const DEFAULT_TASKS = [
        [
            'status' => true,
            'code' => 'LIT-001',
            'rank' => 1,
            'title' => 'Task 1',
            'type' => 'type 1',
            'litigation_id' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
        [
            'status' => true,
            'code' => 'LIT-002',
            'rank' => 2,
            'title' => 'Task 2',
            'type' => 'type 2',
            'litigation_id' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
        [
            'status' => true,
            'code' => 'LIT-003',
            'rank' => 3,
            'title' => 'Task 3',
            'type' => 'type 3',
            'litigation_id' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
    ];
}
