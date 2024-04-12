<?php

namespace App\Models\Shareholder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'price_action_unity',
    ];

}
