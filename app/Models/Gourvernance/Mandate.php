<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    use HasFactory, HasUuids;

    const STATUS = [
        'active',
        'expired',
    ];

    protected $fillable = [
        'appointment_date',
        'renewal_date',
        'expiry_date',
        'status',
    ];

    public function mandatable()
    {
        return $this->morphTo();
    }
}
