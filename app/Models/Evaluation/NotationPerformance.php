<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotationPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'notation_id',
        'collaborator_id',
    ];

    public function notation()
    {
        return $this->belongsTo(Notation::class);
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }
}
