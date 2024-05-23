<?php

namespace App\Models\Evaluation;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'collaborator_id',
        'date',
        'created_by',
        'parent_id',
    ];

    protected $appends = ['indicators', 'steps'];

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

     public function getStepsAttribute() {

        $childrens = self::where('parent_id', $this->id)->get()->makeHidden(['performances', 'steps']);
        $parent = collect([self::find($this->id)->makeHidden(['performances', 'steps'])]);

        $steps = $parent->merge($childrens);

        return $steps;
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
