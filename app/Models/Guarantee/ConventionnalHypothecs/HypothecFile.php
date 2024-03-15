<?php

namespace App\Models\Guarantee\ConventionnalHypothecs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypothecFile extends Model
{
    use HasFactory;


    /**
     * @property int $id
     * @property string $name
     */
    protected $fillable = array(
        'name',
        'file',
    );
}
