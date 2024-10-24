<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutiveCommittee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'committee_id',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function committable()
    {
        return $this->morphTo();
    }
}
