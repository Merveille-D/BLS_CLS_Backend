<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GourvernanceDocument extends Model
{
    use HasFactory, HasUuids;

    const FILE_STATUS = [
        'pending',
        'post_ag',
        'post_ca',
        'post_cd',
        'closed',
    ];

    protected $fillable = [
        'name',
        'file',
        'status',
    ];

}
