<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'position',
        'type',
        'note',
        'description',
    ];

    const POSITIONS = [
        'lawyer',
        'notary',
        'hussier',
        'real estate expert',
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


}
