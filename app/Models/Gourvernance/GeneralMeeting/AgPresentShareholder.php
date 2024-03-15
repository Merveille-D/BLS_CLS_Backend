<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgPresentShareholder extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     * @property string $file
     * @property int $general_meeting_id
     */
    protected $fillable = array(
        'shareholder_firstname',
        'shareholder_lastname',
        'general_meeting_id',
    );

    public function generalMeeting()
    {
        return $this->belongsTo(GeneralMeeting::class);
    }
}
