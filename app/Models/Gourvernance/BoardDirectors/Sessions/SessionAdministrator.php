<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'session_date',
        'type'
    ];
}
