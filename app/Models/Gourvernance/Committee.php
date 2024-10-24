<?php

namespace App\Models\Gourvernance;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory, HasUuids;

    const TYPES = [
        'ca',
        'cd',
    ];

    protected $fillable = [
        'name',
        'type',
    ];

    public function executiveCommittees()
    {
        return $this->hasMany(ExecutiveCommittee::class);
    }
}
