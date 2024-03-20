<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionStep extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     */
    protected $fillable = array(
        'name',
    );

    public function session_administrators()
    {
        return $this->hasMany(SessionAdministrator::class);
    }

    public function type_files()
    {
        return $this->hasMany(SessionStepTypeFile::class);
    }

    const NEXT_STEP = [
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 4,
    ];
}
