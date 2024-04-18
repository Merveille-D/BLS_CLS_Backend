<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvHypothecStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =  [
        'code', 'name', ' max_delay', 'min_delay', 'type'
    ];

    public function steps()
    {
        return $this->hasMany(ConvHypothecStep::class, 'stepable_id');
    }


    public function getDeadlineAttribute() {
        // dd($this);
        if ($this->status)
            return $this->created_at;
        elseif ($this->max_deadline && $this->min_deadline)
            return 'Du '.$this->min_deadline. ' au ' . $this->max_deadline;
        elseif ($this->max_deadline)
            return $this->max_deadline;
        elseif ($this->min_deadline)
            return $this->min_deadline;

        return null;
    }

}
