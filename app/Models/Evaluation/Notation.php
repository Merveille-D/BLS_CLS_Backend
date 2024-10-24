<?php

namespace App\Models\Evaluation;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class Notation extends Model
{
    use Alertable, HasFactory, HasUuids, Transferable;

    protected $fillable = [
        'note',
        'status',
        'observation',
        'collaborator_id',
        'created_by',
        'parent_id',
        'reference',
        'evaluation_reference',
    ];

    protected $appends = ['indicators'];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function performances()
    {
        return $this->hasMany(NotationPerformance::class);
    }

    public function getLastNotationAttribute()
    {

        $transfer_notation = self::where('parent_id', $this->id)
            ->whereNotNull('note')
            ->orderBy('created_at', 'desc')
            ->first();

        return ($transfer_notation) ? $transfer_notation : self::find($this->id);
    }

    public function getIndicatorsAttribute()
    {

        $indicators = [];
        foreach ($this->performances as $performance) {
            $performance->performanceIndicator->position = $performance->performanceIndicator->position;
            $indicators[] = [
                'performance_indicator' => $performance->performanceIndicator,
                'note' => $performance->note,
            ];

        }

        return $indicators;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
