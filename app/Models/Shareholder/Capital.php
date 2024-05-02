<?php

namespace App\Models\Shareholder;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'date',
        'amount',
        'par_value',
    ];

}
