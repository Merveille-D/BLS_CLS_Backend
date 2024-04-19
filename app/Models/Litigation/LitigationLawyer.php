<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationLawyer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'phone', 'email'
    ];

    public function litigation()
    {
        return $this->morphOne(Litigationable::class, 'litigationable');
    }
}
