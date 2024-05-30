<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'residence',
        'zip_code',
        'number_rccm',
        'number_ifu',
        'id_card',
        'capital',
        'permanent_representative_id',
        'type',
        'created_by'
    ];

    const TYPES_PART = [
        'individual',
        'corporate',
    ];
}
