<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Guarantee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'status',
        'reference',
        'type',
        'contract_id'
    ];

    public function tasks() {
        return $this->morphMany(HypothecTask::class, 'taskable');
    }

    public function getNextTaskAttribute() {
        return $this->tasks()->where('type', '!=', 'task')
                ->where('status', false)->orderBy('rank')->first();
    }

    public function getCurrentTaskAttribute() {
        return $this->tasks()->where('type', '!=', 'task')
                    ->where('status', true)->orderBy('rank', 'desc')->first();
    }


}
