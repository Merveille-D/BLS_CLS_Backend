<?php

namespace App\Models\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'buyer_id',
        'count_actions',
        'lastname',
        'firstname',
        'status',
        'ask_date',
        'ask_agrement',
    ];

    const STATUS = ['pending', 'accepted', 'rejected'];

    public function fileUploads()
    {
        return $this->morphMany(GourvernanceDocument::class, 'uploadable');
    }



}
