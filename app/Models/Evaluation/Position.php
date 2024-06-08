<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
    ];

    protected $appends = ['collaborators', 'indicators'];

    public function getCollaboratorsAttribute()
    {
        return $this->hasMany(Collaborator::class);
    }

    public function getIndicatorsAttribute()
    {
        return $this->hasMany(PerformanceIndicator::class);
    }
}
