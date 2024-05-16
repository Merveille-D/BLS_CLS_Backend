<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorIncident extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'telephone',
    ];
}
