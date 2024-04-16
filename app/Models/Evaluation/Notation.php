<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'collaborator_id',
    ];

    const TYPES =[
        'evaluated',
        'verified',
        'validated',
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }
}
