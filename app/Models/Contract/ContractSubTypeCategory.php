<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractSubTypeCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type_category_id',
        'value',
    ];

    public function typeCategory()
    {
        return $this->belongsTo(ContractTypeCategory::class);
    }
}
