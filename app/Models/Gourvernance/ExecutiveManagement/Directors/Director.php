<?php

namespace App\Models\Gourvernance\ExecutiveManagement\Directors;

use App\Models\Gourvernance\Mandate;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory, HasUuids;

    /**
     * Class Director
     *
     * @property int $id Primary
     */
    protected $fillable = [
        'name',
        'birthdate',
        'position',
        'birthplace',
        'nationality',
        'address',
    ];

    public function mandates()
    {
        return $this->morphMany(Mandate::class, 'mandatable')->orderBy('created_at', 'desc');
    }

    public function lastMandate()
    {
        return $this->mandates()->latest()->first();
    }

    public function executiveCommittees()
    {
        return $this->morphMany(ExecutiveCommittee::class, 'committable');
    }
}
