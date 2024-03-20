<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Models\Gourvernance\GeneralMeeting\AgAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgStepTypeFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ag_step_id',
    ];

    public function step()
    {
        return $this->belongsTo(AgStep::class);
    }

    public function files()
    {
        return $this->hasMany(AgStepFile::class);
    }

}
