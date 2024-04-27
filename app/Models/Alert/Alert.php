<?php

namespace App\Models\Alert;

use App\Observers\Alert\AlertObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([AlertObserver::class])]
class Alert extends Model
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = ['state', 'sent_by', 'sent_to', 'deadline', 'title', 'message', 'type', 'trigger_at', 'priority'];

    const STATUS = [
        'info',
        'warning',
        'urgent',
    ];

    const MODULES = [
        'contract',
        'general_meeting',
    ];

    public function alertable()
    {
        return $this->morphTo();
    }
}
