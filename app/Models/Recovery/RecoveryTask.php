<?php

namespace App\Models\Recovery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryTask extends Model
{
    use HasFactory;

    protected $table = 'recovery_task';

    public function recovery()
    {
        return $this->belongsTo(Recovery::class, 'recovery_id');
    }
}
