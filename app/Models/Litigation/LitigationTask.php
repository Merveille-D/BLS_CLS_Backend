<?php

namespace App\Models\Litigation;

use App\Concerns\Traits\Transfer\Transferable;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationTask extends Model
{
    use HasFactory, HasUuids, Transferable;

    protected $fillable = [
        'status',
        'code',
        'rank',
        'name',
        'type',
        'litigation_id',
        'created_by',
        'min_deadline',
        'max_deadline',
    ];

    protected $casts = [
        'status' => 'boolean',
        // 'min_deadline' => 'date',
        // 'max_deadline' => 'date',
    ];

    public function litigation()
    {
        return $this->belongsTo(Litigation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function litigationTaskHistories()
    // {
    //     return $this->hasMany(LitigationTaskHistory::class);
    // }

    const DEFAULT_TASKS = [
        [
            'status' => true,
            'code' => 'LIT-001',
            'rank' => 1,
            'name' => 'Task 1',
            'type' => 'type 1',
            'litigation_id' => '1',
            'created_by' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
        [
            'status' => true,
            'code' => 'LIT-002',
            'rank' => 2,
            'name' => 'Task 2',
            'type' => 'type 2',
            'litigation_id' => '1',
            'created_by' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
        [
            'status' => true,
            'code' => 'LIT-003',
            'rank' => 3,
            'name' => 'Task 3',
            'type' => 'type 3',
            'litigation_id' => '1',
            'created_by' => '1',
            'min_deadline' => '2024-05-02',
            'max_deadline' => '2024-05-02',
        ],
    ];
}
