<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
    ];

}
