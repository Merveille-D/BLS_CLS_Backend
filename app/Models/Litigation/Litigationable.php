<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litigationable extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'litigation_id',
        'litigationable_id',
        'litigationable_type',
        'category',
        'type',
        'party_id'
    ];

    public function litigationable()
    {
        return $this->morphTo();
    }

}
