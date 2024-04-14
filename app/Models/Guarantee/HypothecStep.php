<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HypothecStep extends Pivot
{
    use HasFactory;

    protected $fillable =  [
        'status', 'name', ' max_delay', 'min_delay',
    ];


    protected $timestamps = true;
}
