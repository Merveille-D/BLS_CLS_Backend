<?php

namespace App\Models\Gourvernance\BankInfo;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'logo',
        'denomination',
        'siege_social',
        'par_value',
        'total_shareholders'
    ];
}
