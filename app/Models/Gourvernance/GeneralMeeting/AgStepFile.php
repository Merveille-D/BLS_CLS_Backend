<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgStepFile extends Model
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
        'general_meeting_id',
        'ag_step_type_file_id',
    ];

    public function step()
    {
        return $this->belongsTo(AgStep::class);
    }

    public function type_file()
    {
        return $this->belongsTo(AgStepTypeFile::class);
    }


}
