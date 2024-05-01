<?php

namespace App\Models\Transfer;

use App\Concerns\Traits\Alert\Alertable;
use App\Models\User;
use App\Observers\Transfer\TransferObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TransferObserver::class])]
class Transfer extends Model
{
    use HasFactory, HasUuids, Alertable;

    protected $fillable = [
        'status',
        'title',
        'description',
        'sender_id',
        'deadline',
        'created_at',
    ];

    function sender()
    {
        return $this->belongsTo(User::class, 'id', 'sender_id');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'transfer_user',/*  'user_id', 'transfer_id' */);
    }

    public function transferable()
    {
        return $this->morphTo();
    }
}
