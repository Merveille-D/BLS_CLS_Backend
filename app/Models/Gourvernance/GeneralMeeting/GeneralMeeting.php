<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralMeeting extends Model
{
    use HasFactory;

    protected $fillable = array(
        'libelle',
        'reference',
        'meeting_date',
        'type',
        'ag_step_id',
    );


    const GENERAL_MEETING_TYPES = [
        'ordinary',
        'extraordinary',
        'annual',
    ];

    public function step()
    {
        return $this->belongsTo(AgStep::class, 'ag_step_id');
    }

    public function files()
    {
        return $this->hasMany(AgStepFile::class);
    }

}
