<?php

namespace App\Models\Recovery;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryDocument extends Model
{
    use HasFactory, HasUuids;

    public function documentable()
    {
        return $this->morphTo();
    }
}
