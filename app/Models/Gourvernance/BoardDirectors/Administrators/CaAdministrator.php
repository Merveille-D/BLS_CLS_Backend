<?php

namespace App\Models\Gourvernance\BoardDirectors\Administrators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaAdministrator extends Model
{
    use HasFactory;

/**
 * Class CaAdministrator
 *
 * @property int $id Primary
 *
 * @package App\Models
 */

    protected $fillable = [
        'firstname',
        'lastname',
        'birthday',
        'birthplace',
        'age',
        'nationality',
        'address',
        'denomination',
        'siege',
        'grade',
        'representant',
        'quality',
        'is_uemoa',
        'avis_cb',
    ];

    public function procedures()
    {
        return $this->hasMany(CaProcedure::class);
    }

}
