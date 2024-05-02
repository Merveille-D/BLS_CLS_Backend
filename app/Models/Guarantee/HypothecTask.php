<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Transfer\Transferable;
use App\Enums\ConvHypothecState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothecTask extends Model
{
    use HasFactory, HasUuids, Transferable;

    protected $fillable = [
        'status',
        'code',
        'rank',
        'name',
        'type',
        'hypothec_id',
        'min_deadline',
        'max_deadline',
    ];

    protected $casts = [
        'status' => 'boolean',
        // 'min_deadline' => 'date',
        // 'max_deadline' => 'date',
    ];

    public function hypothec()
    {
        return $this->belongsTo(ConvHypothec::class, 'hypothec_id');
    }

    public function getCompletedMinDateAttribute() {
        if ($this->status) {
            return null;
        }
        return $this->min_deadline;
    }

    public function getCompletedMaxDateAttribute() {
        if ($this->status) {
            return $this->getDatebyStatus($this->code);
        }
        return $this->max_deadline;
    }

    public function getDatebyStatus($state) {
        $hypo = $this->hypothec;

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
