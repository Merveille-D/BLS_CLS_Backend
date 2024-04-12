<?php

namespace App\Models\Shareholder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'buyer_id',
        'count_actions',
        'lastname',
        'firstname',
        'agrement_ca',
    ];

    const STATUS = ['pending', 'accepted', 'rejected'];

}
