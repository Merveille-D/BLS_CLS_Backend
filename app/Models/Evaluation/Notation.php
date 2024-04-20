<?php

namespace App\Models\Evaluation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'collaborator_id',
    ];

    const STATUS =[
        'evaluated',
        'verified',
        'validated',
        'archived'
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function performances()
    {
        return $this->hasMany(NotationPerformance::class);
    }

    public function getIndicatorsAttribute() {

        $indicators = [];

        foreach ($this->performances as $performance) {
            $indicators[] = [
                'performance_indicator' => $performance->performanceIndicator,
                'note' => $performance->note,
            ];

        }
        return $indicators;
    }
}
