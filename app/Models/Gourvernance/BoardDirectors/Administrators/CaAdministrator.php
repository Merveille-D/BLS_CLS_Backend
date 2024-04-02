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
        'name',
        'birthdate',
        'birthplace',
        'email',
        'age',
        'nationality',
        'address',
        'shares',
        'quality',
        'function',
        'permanent_representative_id',
        'share_percentage',
        'type',
    ];

    public function scopeAdministrator($query) {
        return $query->whereNotNull('type');
    }

    public function representing() {
        return $this->hasOne(CaAdministrator::class, 'id', 'permanent_representative_id');
    }

}
