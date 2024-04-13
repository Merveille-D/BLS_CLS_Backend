<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPart extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'description',
        'type',
        'contract_ipd',
        'part_id',
    ];

    const TYPE = [
        'part_1',
        'part_2'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}

