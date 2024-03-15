<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothecStep extends Model
{
    use HasFactory;

    /**
     * fillable properties
     * @property int $id
     * @property string $name
     * @property string $type
     */
    protected $fillable = array(
        'name',
        'type',
    );
}
