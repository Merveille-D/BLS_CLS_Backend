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
        'tier_id',
        'type',
        'count_actions',
        'status',
        'transfer_date',
        'created_by',
    ];

    const STATUS = ['pending', 'accepted', 'rejected', 'cancelled'];
    
    const TYPES = ['shareholder', 'tier'];

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
