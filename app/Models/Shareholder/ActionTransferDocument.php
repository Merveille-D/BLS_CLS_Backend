<?php

namespace App\Models\Shareholder;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionTransferDocument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'file',
        'uploadable'
    ];
}
