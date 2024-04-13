<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'file_name',
        'file_url',
        'link',
        'type',
    ];

    const TYPES = [
        'link',
        'file',
    ];
}
