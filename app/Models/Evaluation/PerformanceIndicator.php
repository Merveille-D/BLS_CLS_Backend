<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'position_name',
        'type',
        'note',
        'description',
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
