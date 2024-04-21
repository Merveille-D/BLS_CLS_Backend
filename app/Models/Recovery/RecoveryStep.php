<?php

namespace App\Models\Recovery;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryStep extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'code',
        'rank',
        'type',
        'deadline'
    ];

    public function steps()
    {
        return $this->hasMany(RecoveryStep::class, 'stepable_id');
    }

}
