<?php

namespace App\Models\Gourvernance\BoardDirectors\Sessions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionStepFile extends Model
{
    use HasFactory;

    /**
     * Class AgActionFile
     *
     * @property int $id Primary
     *
     * @package App\Models
     */

    protected $fillable = [
        'file',
        'session_administrator_id',
        'session_step_type_file_id',
    ];

    public function step()
    {
        return $this->belongsTo(SessionStep::class);
    }

    public function type_file()
    {
        return $this->belongsTo(SessionStepTypeFile::class);
    }


}
