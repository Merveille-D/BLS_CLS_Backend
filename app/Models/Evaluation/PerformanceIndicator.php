<?php

namespace App\Models\Evaluation;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class PerformanceIndicator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'position',
        'type',
        'note',
        'description',
        'created_by',
    ];

    const POSITIONS = [
        'lawyer',
        'notary',
        'hussier',
        'real_estate_expert',
    ];

    const TYPES = [
        'quantitative',
        'qualitative',
    ];

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function notations()
    {
        return $this->hasMany(Notation::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
