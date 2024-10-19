<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTypeCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category_id',
        'keyword',
        'value',
    ];

    public function category()
    {
        return $this->belongsTo(ContractCategory::class);
    }

    public function subTypeCategories()
    {
        return $this->hasMany(ContractSubTypeCategory::class);
    }
}
