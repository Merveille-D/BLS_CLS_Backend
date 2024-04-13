<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvHypothecStep extends Model
{
    use HasFactory;

    protected $fillable =  [
        'code', 'name', ' max_delay', 'min_delay', 'type'
    ];

    public function steps()
    {
        return $this->hasMany(ConvHypothecStep::class, 'stepable_id');
    }
}
