<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditPeriod extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'date',
        'status',
    ];

}
