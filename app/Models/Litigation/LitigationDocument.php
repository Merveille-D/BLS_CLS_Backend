<?php

namespace App\Models\Litigation;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitigationDocument extends Model
{
    use HasFactory, HasUuids;

    public function documentable()
    {
        return $this->morphTo();
    }
}
