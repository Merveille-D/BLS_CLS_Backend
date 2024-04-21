<?php

namespace App\Models\Recovery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryFollow extends Model
{
    use HasFactory;

    public function follows()
    {
        return $this->hasMany(RecoveryFollow::class, 'stepable_id');
    }
}
