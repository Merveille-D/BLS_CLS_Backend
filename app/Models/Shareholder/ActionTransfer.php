<?php

namespace App\Models\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionTransfer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'owner_id',
        'buyer_id',
        'count_actions',
        'lastname',
        'firstname',
        'status',
        'transfer_date',
        'ask_date',
        'ask_agrement',
    ];

    const STATUS = ['pending', 'accepted', 'rejected'];

    public function fileUploads()
    {
        return $this->morphMany(GourvernanceDocument::class, 'uploadable');
    }

    public function owner()
    {
        return $this->belongsTo(Shareholder::class, 'owner_id');
    }

    public function buyer()
    {
        return $this->belongsTo(Shareholder::class, 'buyer_id');
    }



}
