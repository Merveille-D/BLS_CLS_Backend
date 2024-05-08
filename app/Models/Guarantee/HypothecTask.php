<?php

namespace App\Models\Guarantee;

use App\Concerns\Traits\Guarantee\HypothecFormFieldTrait;
use App\Concerns\Traits\Transfer\Transferable;
use App\Enums\ConvHypothecState;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothecTask extends Model
{
    use HasFactory, HasUuids, Transferable, HypothecFormFieldTrait;

    protected $table = 'module_tasks';

    protected $fillable = [
        'status',
        'code',
        'rank',
        'title',
        'type',
        'taskable_id',
        'taskable_type',
        'created_by',
        'min_deadline',
        'max_deadline',
    ];

    protected $casts = [
        'status' => 'boolean',
        // 'min_deadline' => 'date',
        // 'max_deadline' => 'date',
    ];

    public function taskable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    const MODULES = [
        'conv_hypothec' => ConvHypothec::class,
        'guarantee' => Guarantee::class,
        // 'litigation' => Litigation::class,
        // 'recovery' => Recovery::class
    ];

    public function getFormAttribute() {
        $form = $this->getCustomFormFields($this->code);

        return $form;
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

    public function getValidationAttribute()
    {
        $step = $this->taskable->next_task;

        if (!$step) {
            return [];
        }
        $form = $this->getCustomFormFields($step->code);

        return [
            'method' => 'POST',
            'action' => env('APP_URL') . '/api/conventionnal_hypothec/update/' . $this->taskable->id,
            'form' => $form,
        ];
    }

    public function getDatebyStatus($state) {
        $hypo = $this->taskable;

        $date = null;
        switch ($state) {
            case ConvHypothecState::REGISTER_REQUEST_FORWARDED:
                $date = $hypo->forwarded_date;
            break;
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
