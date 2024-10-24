<?php

namespace App\Models\Guarantee;

use App\Enums\ConvHypothecState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvHypothecStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code', 'name', ' max_delay', 'min_delay', 'type',
    ];

    public function steps()
    {
        return $this->hasMany(ConvHypothecStep::class, 'stepable_id');
    }

    public function conv_hypothecs()
    {
        return $this->belongsToMany(ConvHypothec::class, 'hypothec_step', 'step_id', 'hypothec_id');
    }

    public function getCompletedMinDateAttribute()
    {
        if ($this->status) {
            return null;
        }

        return $this->min_deadline;
    }

    public function getCompletedMaxDateAttribute()
    {
        if ($this->status) {
            return $this->getDatebyStatus($this->code);
        }

        return $this->max_deadline;
    }

    public function getDatebyStatus($state)
    {
        $hypo = $this->conv_hypothecs()
            ->whereHypothecId($this->pivot->hypothec_id)
            ->whereStepId($this->pivot->step_id)
            ->first();

        $date = null;
        switch ($state) {
            case ConvHypothecState::REGISTER_REQUESTED:
                $date = $hypo->registering_date;
                break;
            case ConvHypothecState::REGISTER:
                $date = $hypo->registration_date;
                break;
            case ConvHypothecState::NONREGISTER:
                $date = $hypo->registration_date;
                break;
            case ConvHypothecState::SIGNIFICATION_REGISTERED:
                $date = $hypo->date_signification;
                break;
            case ConvHypothecState::ORDER_PAYMENT_VISA:
                $date = $hypo->visa_date;
                break;
            case ConvHypothecState::EXPROPRIATION_SPECIFICATION:
                $date = $hypo->date_deposit_specification;
                break;
            case ConvHypothecState::EXPROPRIATION_SUMMATION:
                $date = $hypo->summation_date;
                break;
            case ConvHypothecState::ADVERTISEMENT:
                $date = $hypo->advertisement_date;
                break;
                // case ConvHypothecState::STATUS_COMPLETED_MIN:
                //     return $this->completed_min_date;
            default:
                $date = null;
                break;
        }

        return $date;
    }
}
