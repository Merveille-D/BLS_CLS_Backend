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
        'corporate_type',
        'actions_number',
        'actions_encumbered',
        'actions_no_encumbered',
        'pourcentage'
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
