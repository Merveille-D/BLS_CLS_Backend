<?php

namespace App\Models\Alert;

use App\Observers\Alert\AlertObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([AlertObserver::class])]
class Alert extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['state', 'sent_by', 'sent_to', 'title', 'message', 'type', 'trigger_at'];
}
