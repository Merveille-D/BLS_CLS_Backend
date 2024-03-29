<?php

namespace App\Models\Alert;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['state', 'sent_by', 'sent_to', 'title', 'message', 'read_at', 'trigger_at'];
}
