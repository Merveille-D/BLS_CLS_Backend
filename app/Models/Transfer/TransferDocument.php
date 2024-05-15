<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDocument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'file',
    ];

}
