<?php

namespace App\Models\Recovery;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Recovery\RecoveryFormFieldTrait;
use App\Models\Guarantee\ConvHypothec;
use App\Models\Guarantee\Guarantee;
use App\Models\ModuleTask;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\Recovery\RecoveryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
#[ScopedBy([CountryScope::class])]
#[ObservedBy([RecoveryObserver::class])]
class Recovery extends Model
{
    use HasFactory, HasUuids, Alertable, RecoveryFormFieldTrait;

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
        'is_archived',
        'contract_id',
        'created_by',
    ];

    protected $casts = [
        'has_guarantee' => 'boolean',
        'is_seized' => 'boolean',
        'is_entrusted' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks() {
        return $this->morphMany(RecoveryTask::class, 'taskable')->defaultOrder();
    }

    public function getNextTaskAttribute() {
        return $this->tasks()
                ->where('status', false)->first();
    }

    public function getCurrentTaskAttribute() {
        return $this->tasks()
                    ->where('status', true)
                    ->get()->last();
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
        return $this->belongsTo(Guarantee::class, 'guarantee_id');
    }

    public function getValidationAttribute()
    {
        $step = $this->next_step;

        if ($step) {
            $form = $this->getCustomFormFields($step->code);

            return [
                'method' => 'POST',
                'action' => env('APP_URL') . '/api/recovery/update/' . $this->id,
                'form' => $form,
            ];
        }
        return null;
    }

    //readable_type
    public function getReadableTypeAttribute()
    {
        $type = '';

        if ($this->type == 'forced') {
            $type = $this->has_guarantee ? 'Forcé avec Garantie' : 'Forcé sans Garantie';
        } elseif ($this->type == 'friendly') {
            $type = $this->has_guarantee ? 'Amiable avec Garantie' : 'Amiable sans Garantie';
        }

        return $type;
    }

    public function getModuleIdAttribute() : string|null {
        return $this->id;
     }
}
