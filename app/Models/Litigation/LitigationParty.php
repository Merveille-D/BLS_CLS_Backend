<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationParty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'category', 'type', 'phone', 'email'
    ];
}
