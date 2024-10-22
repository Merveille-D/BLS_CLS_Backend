<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
    ];

    const TYPES = [
        'ca',
        'cd',
    ];

    public function executiveCommittees()
    {
        return $this->hasMany(ExecutiveCommittee::class);
    }

}
