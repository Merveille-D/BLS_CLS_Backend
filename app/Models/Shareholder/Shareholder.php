<?php

namespace App\Models\Shareholder;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shareholder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
        'nationality',
        'address',
        'corporate_type',
        'actions_number',
        'actions_encumbered',
        'actions_no_encumbered',
        'percentage'
    ];

    const TYPES = [
        'individual',
        'corporate',
    ];

    const CORPORATE_TYPES = [
        'company',
        'institution',
    ];
}
