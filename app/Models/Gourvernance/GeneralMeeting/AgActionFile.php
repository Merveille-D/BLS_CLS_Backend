<?php

namespace App\Models\Gourvernance\GeneralMeeting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgActionFile extends Model
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
        'type',
        'name',
        'file',
        'ag_action_id',
    ];

    public function agAction()
    {
        return $this->belongsTo(AgAction::class);
    }
}
