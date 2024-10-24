<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'value',
    ];

    public function typeCategories()
    {
        return $this->hasMany(ContractTypeCategory::class);
    }
}
