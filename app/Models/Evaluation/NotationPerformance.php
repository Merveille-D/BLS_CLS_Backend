<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotationPerformance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'notation_id',
        'performance_indicator_id',
        'note',
    ];

    public function notation()
    {
        return $this->belongsTo(Notation::class);
    }

    public function performanceIndicator()
    {
        return $this->belongsTo(PerformanceIndicator::class);
    }
}
