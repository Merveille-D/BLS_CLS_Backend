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
    use Alertable, HasFactory, HasUuids;

    protected $fillable = [
        'status',
        'title',
        'description',
        'sender_id',
        'deadline',
        'created_at',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'transfer_user'/*  'user_id', 'transfer_id' */);
    }

    public function transferable()
    {
        return $this->morphTo();
    }

    public function fileTransfers()
    {
        return $this->morphMany(TransferDocument::class, 'uploadable');
    }

    public function audit()
    {
        return $this->hasMany(TransferAudit::class);
    }

    public function evaluation()
    {
        return $this->hasMany(TransferEvaluation::class);
    }

    public function getModuleIdAttribute(): ?string
    {
        return $this->transferable?->id;
    }
}
