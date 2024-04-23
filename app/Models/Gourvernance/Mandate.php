<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'appointment_date',
        'renewal_date',
        'expiry_date',
    ];

    const TYPES = [
        'director',
        'administrator',
    ];
}
