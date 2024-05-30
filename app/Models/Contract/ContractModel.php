<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModel extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'file',
        'contract_model_category_id',
        'created_by'
    ];

}
