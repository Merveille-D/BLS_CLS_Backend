<?php

namespace App\Models\Recovery;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'code',
        'rank',
        'type',
        'min_delay',
        'max_delay',
        'deadline'
    ];

}
