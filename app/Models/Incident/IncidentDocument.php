<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentDocument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'file',
    ];

}
