<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class LitigationParty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'category', 'type', 'phone', 'email'
    ];

    public function litigations() : MorphToMany
    {
        return $this->morphToMany(Litigation::class, 'litigationable');
    }
}
