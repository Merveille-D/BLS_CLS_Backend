<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgType extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     */
    protected $fillable = array(
        'name',
    );
}
