<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'user_id',
        'performance_indicator_id',
    ];

    public function performanceIndicator()
    {
        return $this->belongsTo(PerformanceIndicator::class);
    }
}
