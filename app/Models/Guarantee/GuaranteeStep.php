<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuaranteeStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable =  [
        'guarantee_type', 'code', 'name', 'rank', 'parent_id', 'step_type', 'min_delay', 'max_delay',
        'formalization_type', 'parent_id', 'parent_response', 'title', 'extra'
    ];

    protected $casts = [
        'extra' => 'array'
    ];
}
