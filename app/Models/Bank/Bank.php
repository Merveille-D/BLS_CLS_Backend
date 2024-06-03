<?php

namespace App\Models\Bank;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class Bank extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'file_name',
        'file_url',
        'link',
        'type',
        'created_by',
    ];

    const TYPES = [
        'link',
        'file',
        'other',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
