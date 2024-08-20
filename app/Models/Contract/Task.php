<?php

namespace App\Models\Contract;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use App\Observers\TaskContractObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
#[ObservedBy([TaskContractObserver::class])]
class Task extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;
    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'libelle',
        'deadline',
        'status',
        'contract_id',
        'created_by',
        'completed_by',
        'date',
    ];


    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function fileUploads()
    {
        return $this->morphMany(ContractDocument::class, 'uploadable');
    }

    public function getFolderAttribute() {
        return $this->contract->title;
    }

    public function getValidationAttribute() {

        return [
            'method' => 'PUT',
            'action' => env('APP_URL'). '/api/tasks/' . $this->id,
        ];
    }

    public function getModuleIdAttribute() : string|null {
        return $this->contract?->id;
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
