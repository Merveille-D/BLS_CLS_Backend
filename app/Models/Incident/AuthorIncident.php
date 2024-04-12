<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'telephone',
    ];
}
