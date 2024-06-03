<?php

namespace App\Models\Shareholder;

use App\Models\Gourvernance\GourvernanceDocument;
use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
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
        'created_by',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
