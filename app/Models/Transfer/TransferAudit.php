<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferAudit extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'audit_id',
        'transfer_id',
    ];

}
