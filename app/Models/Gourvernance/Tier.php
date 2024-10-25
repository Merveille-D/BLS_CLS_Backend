<?php

namespace App\Models\Gourvernance;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
class Tier extends Model
{
    use HasFactory, HasUuids;

    const MEETING_TYPE = [
        'general_meeting',
        'session_administrator',
        'management_committee',
    ];

    protected $fillable = [
        'name',
        'grade',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
