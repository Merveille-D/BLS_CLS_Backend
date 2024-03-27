<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GourvernanceDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'status',
    ];

    const FILE_STATUS = [
        'pending',
        'in_progress',
        'closed',
    ];
}
