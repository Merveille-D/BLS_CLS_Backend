<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralMeeting extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property string $name
     * @property string $file
     * @property int $general_meeting_id
     */
    protected $fillable = array(
        'reference',
        'meeting_date',
        'type',
    );


    const GENERAL_MEETING_TYPES = [
        'ordinary',
        'extraordinary',
        'annual',
    ];

    public function actions()
    {
        return $this->hasMany(AgAction::class);
    }

    public function archives()
    {
        return $this->hasMany(AgArchiveFile::class);
    }

    public function shareholders()
    {
        return $this->hasMany(AgPresentShareholder::class);
    }
}
