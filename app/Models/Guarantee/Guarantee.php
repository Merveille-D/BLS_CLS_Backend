<?php

namespace App\Models\Guarantee;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

#[ScopedBy([CountryScope::class])]
class Guarantee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'status',
        'reference',
        'security',
        'type',
        'phase',
        'contract_id',
        'contract_type',
        'is_paid',
        'is_executed',
        'has_recovery',
        'extra',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_executed' => 'boolean',
        'has_recovery' => 'boolean',
        'extra' => 'array',
    ];

    //creator relationship
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    //documents relationship
    public function documents() {
        return $this->morphMany(GuaranteeDocument::class, 'documentable');
    }

    public function tasks() {
        return $this->morphMany(GuaranteeTask::class, 'taskable');
    }

    public function getNextTaskAttribute() {
        return $this->tasks()
                ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
                ->orderBy('max_deadline')
                ->orderBy('rank')
                ->where('status', false)->first();
    }

    public function getCurrentTaskAttribute() {
        return $this->tasks()
                    ->orderByRaw('IF(max_deadline IS NOT NULL, 0, 1)')
                    ->orderByDesc('max_deadline')
                    ->orderByDesc('rank')
                    ->where('status', true)
                    ->first();
    }
}
