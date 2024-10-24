<?php

namespace App\Models\Alert;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory, HasUuids;

    protected $fillable = ['state', 'sent_by', 'type', 'sent_to', 'data', 'alert_id', 'read_at', 'priority'];

    protected $casts = [
        'data' => 'array',
    ];

    protected $keyAlertId = 'string';

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}
