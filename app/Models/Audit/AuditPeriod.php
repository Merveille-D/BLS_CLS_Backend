<?php

namespace App\Models\Audit;

use App\Models\Scopes\CountryScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy([CountryScope::class])]
class AuditPeriod extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'date',
        'status',
        'created_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}
