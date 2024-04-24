<?php

namespace App\Models\Alert;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['state', 'sent_by', 'type', 'sent_to', 'data', 'alert_id', 'read_at'];

    protected $casts = [
        'data' => 'array',
    ];
}
