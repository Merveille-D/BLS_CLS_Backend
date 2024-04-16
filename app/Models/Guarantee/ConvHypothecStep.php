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
        return 'Du 01/02-23/02/2022';
    }

    // public function getFormAttribute() {
    //     // return   {};
    // }


}
