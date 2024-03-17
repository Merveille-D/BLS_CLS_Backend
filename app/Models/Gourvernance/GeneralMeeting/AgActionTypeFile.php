<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use App\Models\Gourvernance\GeneralMeeting\AgAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgActionTypeFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ag_action_id',
    ];

    public function agAction()
    {
        return $this->belongsTo(AgAction::class);
    }
}
