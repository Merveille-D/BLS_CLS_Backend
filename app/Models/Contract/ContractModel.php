<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModel extends Model
{
    use HasFactory, HasUuids;

    const TYPE = [
        'file',
        'folder',
    ];

    protected $fillable = [
        'name',
        'parent_id',
        'type',
        'file_path',
        'created_by',
    ];

}
