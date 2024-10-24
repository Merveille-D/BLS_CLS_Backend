<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code', 'title', 'max_delay', 'min_delay', 'type',
    ];
}
