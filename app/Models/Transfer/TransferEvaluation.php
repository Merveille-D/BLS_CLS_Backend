<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferEvaluation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'evaluation_id',
        'transfer_id',
    ];

}
