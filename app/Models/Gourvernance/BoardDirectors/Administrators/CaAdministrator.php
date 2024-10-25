<?php

namespace App\Models\Gourvernance\BoardDirectors\Administrators;

use App\Models\Gourvernance\ExecutiveCommittee;
use App\Models\Gourvernance\Mandate;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaAdministrator extends Model
{
    use HasFactory, HasUuids;

    /**
     * Class CaAdministrator
     *
     * @property int $id Primary
     */
    protected $fillable = [
        'name',
        'birthdate',
        'birthplace',
        'email',
        'age',
        'nationality',
        'address',
        'shares',
        'quality',
        'function',
        'permanent_representative_id',
        'share_percentage',
        'type',
    ];

    public function scopeAdministrator($query)
    {
        return $query->whereNotNull('type');
    }

    public function representing()
    {
        return $this->hasOne(CaAdministrator::class, 'id', 'permanent_representative_id');
    }

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
