<?php

namespace App\Models\Gourvernance\BoardDirectors\Administrators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaTypeDocument extends Model
{
    use HasFactory;

    /**
     * Class CaTypeDocument
     *
     * @property int $id Primary
     *
     * @package App\Models
     */

    protected $fillable = [
        'name',
    ];
}
