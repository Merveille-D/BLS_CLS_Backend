<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'residence',
        'number_id',
        'zip_code',
        'number_rccm',
        'number_ifu',
        'id_card',
        'capital',
        'permanent_representative_id',
        'type',
    ];

    const TYPES_PART = [
        'individual',
        'corporate',
    ];
}
