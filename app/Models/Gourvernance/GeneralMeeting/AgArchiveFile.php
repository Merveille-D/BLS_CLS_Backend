<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgArchiveFile extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     * @property string $file
     * @property int $general_meeting_id
     */
    protected $fillable = array(
        'name',
        'file',
        'general_meeting_id',
    );
}
