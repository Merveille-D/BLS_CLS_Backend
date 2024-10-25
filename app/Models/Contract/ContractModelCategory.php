<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModelCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
    ];

    public function models()
    {
        return $this->hasMany(ContractModel::class);
    }
}
