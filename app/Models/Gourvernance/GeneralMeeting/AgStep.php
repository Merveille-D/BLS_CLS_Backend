<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgStep extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     */
    protected $fillable = array(
        'name',
    );

    public function general_meetings()
    {
        return $this->hasMany(GeneralMeeting::class);
    }

    public function type_files()
    {
        return $this->hasMany(AgStepTypeFile::class);
    }

    const NEXT_STEP = [
        1 => 2,
        2 => 3,
        3 => 4,
    ];
}
