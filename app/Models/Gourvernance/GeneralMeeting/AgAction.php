<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'is_file',
        'closing_date',
        'general_meeting_id',
        'ag_type_id',
    ];

    public function generalMeeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }

    public function agType()
    {
        return $this->belongsTo(AgType::class);
    }

}
