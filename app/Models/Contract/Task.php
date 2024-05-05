<?php

namespace App\Models\Contract;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Observers\TaskContractObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'created_by'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function getFolderAttribute() {
        return $this->contract->title;
    }

    public function fileUploads()
    {
        return $this->morphMany(File::class, 'uploadable');
    }

    public function getValidationAttribute() {

        return [
            'method' => 'PUT',
            'action' => env('APP_URL'). '/api/tasks/' . $this->id,
        ];
    }
}
