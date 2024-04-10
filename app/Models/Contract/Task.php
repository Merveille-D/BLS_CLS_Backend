<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'deadline',
        'status',
        'contract_id',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function fileUploads()
    {
        return $this->morphMany(File::class, 'uploadable');
    }
}
