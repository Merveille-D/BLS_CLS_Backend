<?php

namespace App\Models\Gourvernance\ExecutiveManagement\Directors;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory, HasUuids;

/**
 * Class Director
 *
 * @property int $id Primary
 *
 * @package App\Models
 */

    protected $fillable = [
        'name',
        'birthdate',
        'birthplace',
        'nationality',
        'address',
    ];

}
