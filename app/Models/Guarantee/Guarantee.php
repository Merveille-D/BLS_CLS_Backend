<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Transfer\Transferable;
use App\Enums\Guarantee\GuaranteeType;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\Guarantee\GuaranteeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

#[ScopedBy([CountryScope::class])]
#[ObservedBy([GuaranteeObserver::class])]
class Guarantee extends Model
{
    use HasFactory, HasUuids, Transferable;

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
        'created_by',
        'formalization_type',
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
                ->defaultOrder()

                ->where('status', false)->first();
    }
    public function getNextTasksAttribute() {
        return $this->tasks()
                ->defaultOrder()
                ->where('status', false)->get();
    }

    public function getCurrentTaskAttribute() {
        return $this->tasks()
                    ->defaultOrder()
                    ->where('status', true)
                    ->get()->last();
    }

    //readable_type
    public function getReadableTypeAttribute() {
        return GuaranteeType::VALUES[$this->type];
    }

    //readable_phase
    public function getReadablePhaseAttribute() {
        if ($this->phase == 'formalization')
            return 'Formalisation';
        else
            return 'Réalisation';
    }
}
