<?php

namespace App\Models\Guarantee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuaranteeDocument extends Model
{
    use HasFactory;


    public function documentable()
    {
        return $this->morphTo();
    }
}
